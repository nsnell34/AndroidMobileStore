package com.example.nicksnell.new457;

import android.app.Activity;
import android.os.AsyncTask;
import android.os.Bundle;
import android.content.Intent;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;
import android.text.SpannableStringBuilder;
import android.text.Spanned;
import android.text.style.URLSpan;
import android.widget.Toast;
import android.widget.CheckBox;
import android.widget.LinearLayout;

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

public class StoreActivity extends Activity {

    private static final String TAG = "StoreActivity";

    public String name;
    public String password;
    public String keywords;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_store);
        Intent intent = getIntent();
        name = intent.getStringExtra("name");
        password = intent.getStringExtra("password");
        keywords = intent.getStringExtra("keywords");
        Log.e(TAG, "keywords: " + keywords);



        StoreActivity.FetchBookInfoTask fetchBookInfoTask = new StoreActivity.FetchBookInfoTask();
        fetchBookInfoTask.execute(name, password);

    }

    private class FetchBookInfoTask extends AsyncTask<String, Void, String> {
        private static final String TAG = "StoreActivity";

        @Override
        protected String doInBackground(String... params) {
            String name = params[0];
            String password = params[1];
            try {
                String link = "http://undcemcs02.und.edu/~nicholas.s.snell/457/Bookstore/BookInfo.php";
                link+="?keywords=" + URLEncoder.encode(keywords, "UTF-8");

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
                    List<String> books = new ArrayList<>();
                    for (int i = 0; i < jsonArray.length(); i++) {
                        JSONObject jsonObj = jsonArray.getJSONObject(i);
                        String bookISBN = jsonObj.getString("ISBN");
                        String bookTitle = jsonObj.getString("title");
                        String bookPrice = jsonObj.getString("price");
                        books.add(bookISBN);
                        books.add(bookTitle);
                        books.add(bookPrice);
                    }
                    populateBookList(books);
                } catch (JSONException e) {
                    Log.e(TAG, "Error parsing JSON: " + e.getMessage());
                }
            } else {
                Toast.makeText(StoreActivity.this, "Error fetching book information", Toast.LENGTH_SHORT).show();
            }
        }

    }


    private void populateBookList(List<String> books) {
        LinearLayout bookListLayout = findViewById(R.id.bookListLayout);
        bookListLayout.removeAllViews();

        LayoutInflater inflater = LayoutInflater.from(this);

        for (int i = 0; i < books.size(); i += 3) {
            String bookISBN = books.get(i);
            final String bookTitle = books.get(i + 1);
            String bookPrice = books.get(i + 2);

            View bookItemView = inflater.inflate(R.layout.book_item_layout, bookListLayout, false);

            CheckBox checkbox = bookItemView.findViewById(R.id.checkbox);
            TextView bookTitleTextView = bookItemView.findViewById(R.id.bookTitle);

            checkbox.setChecked(false);
            bookTitleTextView.setText(bookTitle);
            bookTitleTextView.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    //send to BookActivity class
                    Intent intent = new Intent( StoreActivity.this, BookActivity.class );
                    intent.putExtra("name", name);
                    intent.putExtra("password", password);
                    intent.putExtra("title", bookTitle);
                    startActivity( intent );
                }
            });

            bookListLayout.addView(bookItemView);
        }
    }

    public void OnBackButton (View view){
        Intent intent = new Intent( StoreActivity.this, HomeActivity.class );
        //Log.e(TAG, "Name, pass: " + name + password);
        intent.putExtra("name", name);
        intent.putExtra("password", password);
        startActivity( intent );

    }

    public void onPurchaseButton(View view) {
        LinearLayout bookListLayout = findViewById(R.id.bookListLayout);
        List<String> selectedBooks = new ArrayList<>();

        for (int i = 0; i < bookListLayout.getChildCount(); i++) {
            View bookItemView = bookListLayout.getChildAt(i);
            CheckBox checkbox = bookItemView.findViewById(R.id.checkbox);
            TextView bookTitleTextView = bookItemView.findViewById(R.id.bookTitle);

            if (checkbox.isChecked()) {
                String bookTitle = bookTitleTextView.getText().toString();
                selectedBooks.add(bookTitle);
            }
        }

        if (selectedBooks.isEmpty()) {
            Toast.makeText(this, "Please select at least one book to purchase", Toast.LENGTH_SHORT).show();
        } else {
            PurchaseBook purchaseBook = new PurchaseBook(name, password, selectedBooks);
            purchaseBook.execute();
            Toast.makeText(this, "Purchase Successful", Toast.LENGTH_SHORT).show();
        }
    }

}







