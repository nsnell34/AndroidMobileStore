package com.example.nicksnell.new457;


import android.app.Activity;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;

public class MainActivity extends Activity {
    private EditText nameField, pwordField;


    @Override
    protected void onCreate( Bundle savedInstanceState ) {
        super.onCreate( savedInstanceState );
        setContentView( R.layout.activity_main );
        nameField  = (EditText) findViewById( R.id.editText1 );
        pwordField = (EditText) findViewById( R.id.editText2 );
    }

    // Called when the button signUp is pushed
    public void signUp( View view ) {
        String name  = nameField.getText( ).toString( );
        String pword = pwordField.getText( ).toString( );
        new SigninActivity(this,  1 ).execute( name, pword );
   }

    // Called when the button signIn is pushed
    public void signIn( View view ) {
        String name  = nameField.getText( ).toString( );
        String pword = pwordField.getText( ).toString( );
        new SigninActivity(this,  0 ).execute( name, pword );
    }


}