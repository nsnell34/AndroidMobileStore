package com.example.nicksnell.new457;


import android.app.Activity;
import android.os.Bundle;
import android.content.Intent;
import android.util.Log;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;
import android.text.SpannableStringBuilder;
import android.text.Spanned;
import android.text.style.URLSpan;


public class HomeActivity extends Activity {
    private static final String TAG = "HomeActivity";

    public String name;
    public String password;
    public EditText keywords;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_home);

        Intent intent = getIntent();
        name = intent.getStringExtra("name");
        password = intent.getStringExtra("password");
        keywords = (EditText) findViewById(R.id.keywordText);

        //works
        //Log.d(TAG, "Name: " + name + " Password: " + password);

        TextView tv = (TextView) findViewById( R.id.txtMsg );
        HomeActivity.makeTextViewHyperlink (tv);
        tv.setOnClickListener( new View.OnClickListener( ) {
            @Override
            public void onClick( View v ) {
                String keywordsText = keywords.getText().toString();
                Intent intent = new Intent( HomeActivity.this, StoreActivity.class );
                intent.putExtra("name", name);
                intent.putExtra("password", password);
                intent.putExtra("keywords", keywordsText);
                Log.d(TAG, "keywords: " + keywords);
                startActivity( intent );
            }
        } );
    }

    // Sets a hyperlink style to the textview.
    public static void makeTextViewHyperlink( TextView tv ) {
        SpannableStringBuilder ssb = new SpannableStringBuilder( );
        ssb.append( tv.getText( ) );
        ssb.setSpan( new URLSpan("#"), 0, ssb.length(),
                Spanned.SPAN_EXCLUSIVE_EXCLUSIVE );
        tv.setText( ssb, TextView.BufferType.SPANNABLE );
    }

    public void SignOut(View view){
        Intent intent = new Intent( HomeActivity.this, MainActivity.class );
        startActivity( intent );
    }

    public void ViewAccount(View view){
        Intent intent = new Intent(HomeActivity.this, UserActivity.class);
        intent.putExtra("name", name);
        intent.putExtra("password", password);
        Log.e(TAG, "name, pass: " + name + password);
        startActivity(intent);
    }
}