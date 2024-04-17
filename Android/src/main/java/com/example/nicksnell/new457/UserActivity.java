package com.example.nicksnell.new457;

import android.app.Activity;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Bundle;
import android.content.Intent;
import android.text.Spanned;
import android.text.method.LinkMovementMethod;
import android.text.style.ClickableSpan;
import android.util.Log;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;
import android.text.SpannableStringBuilder;
import android.text.Spanned;
import android.text.style.URLSpan;

import androidx.annotation.NonNull;
import androidx.annotation.RequiresApi;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.URL;
import java.net.URLConnection;
import java.net.URLEncoder;
import java.util.ArrayList;
import java.util.List;


public class UserActivity extends Activity {
    public String name;
    public String password;
    private static final String TAG = "UserActivity";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_userinfo);

        Intent intent = getIntent();
        name = intent.getStringExtra("name");
        password = intent.getStringExtra("password");
        final TextView tv = (TextView) findViewById( R.id.textView );
        tv.setText(name + "'s Account");
        FetchBookInfoTask fetchBookInfoTask = new FetchBookInfoTask();
        fetchBookInfoTask.execute(name, password);

    }
    private class FetchBookInfoTask extends AsyncTask<String, Void, String> {
        @Override
        protected String doInBackground(String... params) {
            String name = params[0];
            String password = params[1];
            try {
                String link = "http://undcemcs02.und.edu/~nicholas.s.snell/457/Bookstore/AccountInfo.php";
                link += "?name=" + URLEncoder.encode(name, "UTF-8");
                link += "&password=" + URLEncoder.encode(password, "UTF-8");

                URL url = new URL(link);
                URLConnection conn = url.openConnection();
                BufferedReader reader = new BufferedReader(new InputStreamReader(conn.getInputStream()));
                StringBuilder sb = new StringBuilder();
                String line;
                while ((line = reader.readLine()) != null) {
                    sb.append(line);
                }
                return sb.toString();
            } catch (Exception e) {
                Log.e(TAG, "Error fetching book information: " + e.getMessage());
                return null;
            }
        }

        protected void onPostExecute(String result) {
            if (result != null) {
                try {
                    JSONObject jsonResponse = new JSONObject(result);

                    JSONArray jsonArray = jsonResponse.getJSONArray("books");
                    List<String> bookTitles = new ArrayList<>();
                    for (int i = 0; i < jsonArray.length(); i++) {
                        JSONObject jsonObj = jsonArray.getJSONObject(i);
                        String bookTitle = jsonObj.getString("title");
                        bookTitles.add(bookTitle);
                    }

                    double totalSpent = jsonResponse.getDouble("total_spent");
                    String totalSpentString = String.format("%.2f", totalSpent);

                    Log.e(TAG, "Books: " + bookTitles);
                    Log.e(TAG, "Total Spent: $" + totalSpentString);

                    populateBookList(bookTitles);
                    displayTotalSpent(totalSpentString);
                } catch (JSONException e) {
                    Log.e(TAG, "Error parsing JSON: " + e.getMessage());
                }
            } else {
                Toast.makeText(UserActivity.this, "Error fetching book information", Toast.LENGTH_SHORT).show();
            }
        }

    }

    private void populateBookList(List<String> bookTitles) {
        TextView bookListTextView = findViewById(R.id.bookListTextView);
        SpannableStringBuilder ssb = new SpannableStringBuilder();
        for (final String title : bookTitles) {
            makeTextViewHyperlink(ssb, title, bookListTextView);
        }
        bookListTextView.setText(ssb, TextView.BufferType.SPANNABLE);
    }

    public void makeTextViewHyperlink(SpannableStringBuilder ssb, final String title, final TextView textView) {
        int start = ssb.length();
        ssb.append(title);
        int end = ssb.length();
        ssb.setSpan(new ClickableSpan() {
            @Override
            public void onClick(@NonNull View widget) {
                Intent intent = new Intent( UserActivity.this, BookActivity.class );
                intent.putExtra("name", name);
                intent.putExtra("password", password);
                intent.putExtra("title", title);
                startActivity( intent );
            }
        }, start, end, Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);
        ssb.append("\n");
        textView.setMovementMethod(LinkMovementMethod.getInstance());
    }



    private void displayTotalSpent(String totalSpentString){
        TextView totalSpentTextView = findViewById(R.id.textView4);
        totalSpentTextView.setText("Total Spent: " + totalSpentString);
    }


        public void OnBackButton (View view){
        Intent intent = new Intent( UserActivity.this, HomeActivity.class );
            //Log.e(TAG, "Name, pass: " + name + password);
        intent.putExtra("name", name);
        intent.putExtra("password", password);
        startActivity( intent );

    }
}
