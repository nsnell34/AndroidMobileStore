package com.example.nicksnell.new457;

import android.app.Activity;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;

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

public class BookActivity extends Activity {

    public String name;
    public String password;
    public String title;
    private static final String TAG = "BookActivity";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_book);

        Intent intent = getIntent();
        name = intent.getStringExtra("name");
        password = intent.getStringExtra("password");
        title = intent.getStringExtra("title");

        BookActivity.FetchBookInfoTask fetchBookInfoTask = new BookActivity.FetchBookInfoTask();
        fetchBookInfoTask.execute(name, password, title);

    }
    private class FetchBookInfoTask extends AsyncTask<String, Void, String> {
        @Override
        protected String doInBackground(String... params) {
            String name = params[0];
            String password = params[1];
            String title = params[2];
            try {
                String link = "http://undcemcs02.und.edu/~nicholas.s.snell/457/Bookstore/BookDisplay.php";
                link += "?name=" + URLEncoder.encode(name, "UTF-8");
                link += "&password=" + URLEncoder.encode(password, "UTF-8");
                link += "&title=" + URLEncoder.encode(title, "UTF-8");

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

                    if (jsonArray.length() > 0) {
                        JSONObject jsonObj = jsonArray.getJSONObject(0);
                        String bookISBN = jsonObj.getString("ISBN");
                        String bookTitle = jsonObj.getString("title");
                        String bookPrice = jsonObj.getString("price");

                        TextView textView8 = findViewById(R.id.textView8);
                        String bookInfo = "ISBN: " + bookISBN + "\nTitle: " + bookTitle + "\nPrice: " + bookPrice;
                        textView8.setText(bookInfo);
                    }
                } catch (JSONException e) {
                    Log.e(TAG, "Error parsing JSON: " + e.getMessage());
                }
            } else {
                Toast.makeText(BookActivity.this, "Error fetching book information", Toast.LENGTH_SHORT).show();
            }
        }


    }


    public void OnBackButton (View view){
        Intent intent = new Intent( BookActivity.this, HomeActivity.class );
        //Log.e(TAG, "Name, pass: " + name + password);
        intent.putExtra("name", name);
        intent.putExtra("password", password);
        startActivity( intent );

    }
}
