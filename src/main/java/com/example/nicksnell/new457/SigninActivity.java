package com.example.nicksnell.new457;

import android.content.Context;
import android.os.AsyncTask;
import android.widget.TextView;
import android.content.Intent;
import android.widget.Toast;
import java.net.URL;
import java.net.URLConnection;
import java.net.URLEncoder;
import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import android.util.Log;

public class SigninActivity extends AsyncTask<String, Void, String> {
    private Context context;
    private String name;
    private String pword;
    private int signUpOrIn = 0;
    private static final String TAG = "SigninActivity";

    public SigninActivity(Context context, int flag ) {
        this.context = context;
        signUpOrIn      = flag;
    }

    protected void onPreExecute( ) { }

    @Override
    protected String doInBackground( String... arg0 ) {
        try {

            name  = (String) arg0[0];
            pword = (String) arg0[1];
            String link  = "http://undcemcs02.und.edu/~nicholas.s.snell/457/Bookstore/";

            // Complete the URL.
            //Sign up -- 0, sign in -- 1
            if ( signUpOrIn == 0 ) {
                // user sign in
                link += "SignIn.php";
                link += "?name="  + URLEncoder.encode( name,  "UTF-8" );
                link += "&pword=" + URLEncoder.encode( pword, "UTF-8" );
            } else {
                // add user to database
                link += "SignUp.php";
                link += "?name="  + URLEncoder.encode( name,  "UTF-8" );
                link += "&pword=" + URLEncoder.encode( pword, "UTF-8" );
            }
            // Connect to the server.
            URL url = new URL( link );
            URLConnection conn = url.openConnection( );
            conn.setDoOutput( true );

            // Read server response.
            BufferedReader reader = new BufferedReader(
                    new InputStreamReader( conn.getInputStream( ) ));
            StringBuilder sb = new StringBuilder( );
            String      line = null;
            while (( line = reader.readLine( ) ) != null ) {
                sb.append( line );
                break;
            }
            String serverResponse = sb.toString();
            Log.d(TAG, "Server Response: " + serverResponse);
            return sb.toString( );

        }
        catch( Exception e ) {
            return new String( "Exception: " + e.getMessage( ) );
        }
    }

    @Override
    protected void onPostExecute( String result ) {
        if (result.equals("1")) {

            Intent intent = new Intent(context, HomeActivity.class);
            intent.putExtra("name", name);
            intent.putExtra("password", pword);
            context.startActivity(intent);


        } if (result.equals("0")){

            Toast.makeText(context, "Login Failed", Toast.LENGTH_SHORT).show();
        } if (result.equals("2")){
            Toast.makeText(context, "User Already Exists", Toast.LENGTH_SHORT).show();

        }

    }
}