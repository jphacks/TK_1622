package www.jigenji.biz.jphacks;

import android.animation.Animator;
import android.animation.AnimatorListenerAdapter;
import android.annotation.TargetApi;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.support.annotation.NonNull;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.app.LoaderManager.LoaderCallbacks;

import android.content.CursorLoader;
import android.content.Loader;
import android.database.Cursor;
import android.net.Uri;
import android.os.AsyncTask;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.PrintStream;
import java.net.HttpURLConnection;

import android.os.Build;
import android.os.Bundle;
import android.provider.ContactsContract;
import android.text.TextUtils;
import android.util.Log;
import android.view.KeyEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.inputmethod.EditorInfo;
import android.widget.ArrayAdapter;
import android.widget.AutoCompleteTextView;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;


import org.json.JSONObject;

import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import static android.Manifest.permission.READ_CONTACTS;

/**
 * A login screen that offers login via email/password.
 */
public class LoginActivity extends AppCompatActivity implements LoaderCallbacks<Cursor> {

    /**
     * Id to identity READ_CONTACTS permission request.
     */
    private static final int REQUEST_READ_CONTACTS = 0;

    /**
     * A dummy authentication store containing known user names and passwords.
     * TODO: remove after connecting to a real authentication system.
     */
    private static final String[] DUMMY_CREDENTIALS = new String[]{
            "foo@example.com:hello", "bar@example.com:world"
    };
    /**
     * Keep track of the login task to ensure we can cancel it if requested.
     */
    private UserLoginTask mAuthTask = null;

    // UI references.
    private AutoCompleteTextView mEmailView;
    private EditText mPasswordView;
    private View mProgressView;
    private View mLoginFormView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        // email入力欄のインスタンス
        mEmailView = (AutoCompleteTextView) findViewById(R.id.email);

        //loadermanagerの生成と初期化
        populateAutoComplete();

        // パスワード入力欄のインスタンス
        mPasswordView = (EditText) findViewById(R.id.password);

        // Enterキーやアクションが選択された時のコールバック処理の設定
        mPasswordView.setOnEditorActionListener(new TextView.OnEditorActionListener() {
            @Override
            public boolean onEditorAction(TextView textView, int id, KeyEvent keyEvent) {
                // idにはenterキー入力の場合にのみEditorInfo.IME_NULLが入る
                // idがエンターキーか, r.id.loginの時
                if (id == R.id.login || id == EditorInfo.IME_NULL) {
                    // attemptloginを実行
                    attemptLogin();
                    return true;
                }
                return false;
            }
        });

        // signinボタンが押された時の実行
        Button mEmailSignInButton = (Button) findViewById(R.id.email_sign_in_button);
        mEmailSignInButton.setOnClickListener(new OnClickListener() {
            // ログインを試みる
            @Override
            public void onClick(View view) {
                attemptLogin();
            }
        });

        // changeボタンが押された時の実行
        Button ChangeSignUnButton = (Button) findViewById(R.id.change_sign_up_button);
        ChangeSignUnButton.setOnClickListener(new OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(LoginActivity.this , SignupActivity.class);
                startActivity(intent);
            }
        });

        mLoginFormView = findViewById(R.id.login_form);
        mProgressView = findViewById(R.id.login_progress);
    }


    //mayRequestContactsを呼び出して、falseだったらreturn,trueだったらloadermanagerのinitloader
    private void populateAutoComplete() {
        // falseだったら、りたーん
        if (!mayRequestContacts()) {
            return;
        }

        // 連絡先のデータの取得を許可されていたら実行
        // loaderManagerのインスタンスを取得->指定したidでloaderの初期化->activeにする
        getLoaderManager().initLoader(0, null, this);
    }

    //
    private boolean mayRequestContacts() {
        // スマホのバージョンがversion_codes.Mより低かったら真を返す
        if (Build.VERSION.SDK_INT < Build.VERSION_CODES.M) {
            return true;
        }
        // 連絡先のデータの取得を許可されていたらtrueを返す
        // checkselfpermission:アプリケーションが指定したパミッションを持っているか判断するメソッド
        // packagemanager.PERMISSION_GRANTED:パミッションが許可されていることを示めす
        if (checkSelfPermission(READ_CONTACTS) == PackageManager.PERMISSION_GRANTED) {
            return true;
        }

        // パミッション要求の根拠を表示するべきかどうか
        if (shouldShowRequestPermissionRationale(READ_CONTACTS)) {
            // スナックバーに表示
            // 第一引数:snackbarをホールドするview, 第二引数:表示する文字, 第三引数:
            Snackbar.make(mEmailView, R.string.permission_rationale, Snackbar.LENGTH_INDEFINITE)
                    // アクションを含める
                    //
                    .setAction(android.R.string.ok, new View.OnClickListener() {
                        @Override
                        @TargetApi(Build.VERSION_CODES.M)
                        public void onClick(View v) {
                            requestPermissions(new String[]{READ_CONTACTS}, REQUEST_READ_CONTACTS);
                        }
                    });
        } else {
            //　
            requestPermissions(new String[]{READ_CONTACTS}, REQUEST_READ_CONTACTS);
        }
        return false;
    }

    /**
     * Callback received when a permissions request has been completed.
     */
    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions,
                                           @NonNull int[] grantResults) {
        if (requestCode == REQUEST_READ_CONTACTS) {
            if (grantResults.length == 1 && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                populateAutoComplete();
            }
        }
    }


    /**
     * Attempts to sign in or register the account specified by the login form.
     * If there are form errors (invalid email, missing fields, etc.), the
     * errors are presented and no actual login attempt is made.
     */

    // 入力値の検証->
    private void attemptLogin() {
        // mAuthTaskがnullでなかったら、
        if (mAuthTask != null) {
            return;
        }

        //
        // Reset errors.
        mEmailView.setError(null);
        mPasswordView.setError(null);

        // 入力値を格納した変数
        // Store values at the time of the login attempt.
        String email = mEmailView.getText().toString();
        String password = mPasswordView.getText().toString();

        // キャンセルフラグをfalseに設定
        boolean cancel = false;
        View focusView = null;

        Log.d("check","validate start");

        //textUtils.isEmpty(s) :sのながさ0とnullをチェック
        // 入力値の検証
        // Check for a valid password, if the user entered one.
        if (!TextUtils.isEmpty(password) && !isPasswordValid(password)) {
            mPasswordView.setError(getString(R.string.error_invalid_password));
            focusView = mPasswordView;
            cancel = true;
        }

        // emailがからじゃないか、要求した書式かチェックする
        // Check for a valid email address.
        if (TextUtils.isEmpty(email)) {
            mEmailView.setError(getString(R.string.error_field_required));
            focusView = mEmailView;
            cancel = true;
        }

        // cancelフラグが立っていたら
        if (cancel) {
            // There was an error; don't attempt login and focus the first
            // form field with an error.
            //エラーのあったviewにフォーカスする
            focusView.requestFocus();
        } else {
            // Show a progress spinner, and kick off a background task to
            // perform the user login attempt.
            // エラーがなければshowprogressを実行
            showProgress(true);

            // mAuthTaskにUserLoginTaskのインスタンスを代入
            mAuthTask = new UserLoginTask(email, password);

            // UserLoginTaskのexecuteメソッドを実行
            mAuthTask.execute((Void) null);
        }
    }

    //emailの検証をするための方法
    private boolean isEmailValid(String email) {
        //TODO: Replace this with your own logic
        return email.contains("@");
    }

    //パスワードを検証するための方法
    private boolean isPasswordValid(String password) {
        //TODO: Replace this with your own logic
        return password.length() > 4;
    }



    /**
     * Shows the progress UI and hides the login form.
     */
    @TargetApi(Build.VERSION_CODES.HONEYCOMB_MR2)
    private void showProgress(final boolean show) {
        // On Honeycomb MR2 we have the ViewPropertyAnimator APIs, which allow
        // for very easy animations. If available, use these APIs to fade-in
        // the progress spinner.

        // 実行環境がhoneycomb_mr2より高かったら
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.HONEYCOMB_MR2) {
            // progressbarの表示時間
            int shortAnimTime = getResources().getInteger(android.R.integer.config_shortAnimTime);


            mLoginFormView.setVisibility(show ? View.GONE : View.VISIBLE);
            mLoginFormView.animate().setDuration(shortAnimTime).alpha(
                    show ? 0 : 1).setListener(new AnimatorListenerAdapter() {
                @Override
                public void onAnimationEnd(Animator animation) {
                    mLoginFormView.setVisibility(show ? View.GONE : View.VISIBLE);
                }
            });

            // 引数がtureだったらprogressbarを表示に切り替え
            mProgressView.setVisibility(show ? View.VISIBLE : View.GONE);

            // progressbarに
            mProgressView.animate().setDuration(shortAnimTime).alpha(
                    show ? 1 : 0).setListener(new AnimatorListenerAdapter() {
                @Override
                public void onAnimationEnd(Animator animation) {
                    mProgressView.setVisibility(show ? View.VISIBLE : View.GONE);
                }
            });

            //実行環境がhoneycomb_mr2より低かったら
        } else {
            // The ViewPropertyAnimator APIs are not available, so simply show
            // and hide the relevant UI components.
            mProgressView.setVisibility(show ? View.VISIBLE : View.GONE);
            mLoginFormView.setVisibility(show ? View.GONE : View.VISIBLE);
        }
    }

    @Override
    public Loader<Cursor> onCreateLoader(int i, Bundle bundle) {
        return new CursorLoader(this,
                // Retrieve data rows for the device user's 'profile' contact.
                Uri.withAppendedPath(ContactsContract.Profile.CONTENT_URI,
                        ContactsContract.Contacts.Data.CONTENT_DIRECTORY), ProfileQuery.PROJECTION,

                // Select only email addresses.
                ContactsContract.Contacts.Data.MIMETYPE +
                        " = ?", new String[]{ContactsContract.CommonDataKinds.Email
                .CONTENT_ITEM_TYPE},

                // Show primary email addresses first. Note that there won't be
                // a primary email address if the user hasn't specified one.
                ContactsContract.Contacts.Data.IS_PRIMARY + " DESC");
    }

    @Override
    public void onLoadFinished(Loader<Cursor> cursorLoader, Cursor cursor) {
        List<String> emails = new ArrayList<>();
        cursor.moveToFirst();
        while (!cursor.isAfterLast()) {
            emails.add(cursor.getString(ProfileQuery.ADDRESS));
            cursor.moveToNext();
        }

        addEmailsToAutoComplete(emails);
    }

    @Override
    public void onLoaderReset(Loader<Cursor> cursorLoader) {

    }

    private void addEmailsToAutoComplete(List<String> emailAddressCollection) {
        //Create adapter to tell the AutoCompleteTextView what to show in its dropdown list.
        ArrayAdapter<String> adapter =
                new ArrayAdapter<>(LoginActivity.this,
                        android.R.layout.simple_dropdown_item_1line, emailAddressCollection);

        mEmailView.setAdapter(adapter);
    }


    private interface ProfileQuery {
        String[] PROJECTION = {
                ContactsContract.CommonDataKinds.Email.ADDRESS,
                ContactsContract.CommonDataKinds.Email.IS_PRIMARY,
        };

        int ADDRESS = 0;
        int IS_PRIMARY = 1;
    }

    /**
     * Represents an asynchronous login/registration task used to authenticate
     * the user.
     */
    public class UserLoginTask extends AsyncTask<Void, Void, Boolean> {

        private final String mEmail;
        private final String mPassword;
        private String result;

        HttpURLConnection con = null;

        // コンストラクタ,email,passwordを代入
        UserLoginTask(String email, String password) {
            mEmail = email;
            mPassword = password;
        }

        //非同期処理の本体
        //引数は非同期処理内容を渡すためのパラメタ配列
        @Override
        protected Boolean doInBackground(Void... params) {
            // TODO: attempt authentication against a network service.
            Log.d("check","start");
//
            // networkアクセス
            try {
                Log.d("check","interval1");
                URL urlLogin = new URL("http://153.126.190.51/server/controller/LoginController_s.php");
                Log.d("check","interval2");
                con = (HttpURLConnection) urlLogin.openConnection();
                Log.d("check","interval3");
                con.setConnectTimeout(100000);
                con.setReadTimeout(100000);
                con.setRequestMethod("POST");
                con.setRequestProperty("Accept-Language", "jp");
                con.setUseCaches(false);
                con.setDoOutput(true);
                con.setDoInput(true);
                con.setRequestProperty("Content-Type", "application/json; charset=utf-8");
                Log.d("check","interval4");
                con.connect();


                //outputstreamを開く
                OutputStream outputStream = con.getOutputStream();

                //送る連想配列を指定
                HashMap<String, Object> jsonMap = new HashMap<>();
                jsonMap.put("flag" , "LI");
                jsonMap.put("username" , mEmail);
                jsonMap.put("password" , mPassword);

                // jsonファイルを送信
                if (jsonMap.size() > 0) {
                    //JSON形式の文字列に変換する。
                    JSONObject responseJsonObject = new JSONObject(jsonMap);
                    // json形式の書式で出力
                    String jsonText = responseJsonObject.toString();
                    PrintStream ps = new PrintStream(con.getOutputStream());
                    ps.print(jsonText);
                    ps.close();
                }
                outputStream.close();


                String responseData = "";
                int statusCode = con.getResponseCode();
                InputStream inputstream = con.getInputStream();
                StringBuffer sb = new StringBuffer();
                String line = "";
                BufferedReader br = new BufferedReader(new InputStreamReader(inputstream, "UTF-8"));
                while ((line = br.readLine()) != null) {
                    sb.append(line);
                }


                inputstream.close();
                responseData = sb.toString();
                result = responseData;
                con.disconnect();



                Thread.sleep(0);
            } catch (InterruptedException e) {
                Log.d("check1",e.getMessage());
                result ="401";
                return false;
            } catch (MalformedURLException e){
                Log.d("check2",e.getMessage());
                result ="401";
                return false;
            }   catch (IOException e){
                Log.d("check3",e.getMessage());
                result ="404";
                return false;
            }


            Log.d("responsecode",result);
//            //DUMMY_CREDENTIALS配列に登録されていた値をmap
//            for (String credential : DUMMY_CREDENTIALS) {
//                // 値からを:で配列に分ける
//                String[] pieces = credential.split(":");
//                // 入力したメールアドレスがDUMMY_CREDENTIALSのメールと等しかったら
//                if (pieces[0].equals(mEmail)) {
//                    // Account exists, return true if the password matches.
//                    // 入力したパスワードがDUMMY_CREDENTIALSに等しかったらtrueを返す
//                    return pieces[1].equals(mPassword);
//                }
//            }

            //パスワードが一致しなかったら登録->ここは失敗に書き換える
            // TODO: register the new account here.

            if(result.length()==3){
                if(Integer.parseInt(result) == 401){
                    Log.d("success","false");
                    return false;
                }else if(Integer.parseInt(result) == 402){

                    Log.d("success","false");
                    return false;
                }else if(Integer.parseInt(result) == 403){
                    Log.d("success","false");
                    return false;
                }
            }


//            if(result == '401'){
//                Log.d("success","false");
//                return false;
//            }else if(result == '402'){
//
//                Log.d("success","false");
//                return false;
//            }else if(result == "403"){
//                Log.d("success","false");
//                return false;
//            }else{
//                Log.d("success","true");
//                return true;
//            }

            return true;

        }

        //非同期処理実行後にUIスレッドで実行する処理
        //引数はexecute()の返り値
        @Override
        protected void onPostExecute(final Boolean success) {
            mAuthTask = null;
            showProgress(false);

            Log.d("success","last");
            //成功した時の処理
            if (success) {
                SharedPreferences prefs = getSharedPreferences("SaveData", Context.MODE_PRIVATE);
                SharedPreferences.Editor editor = prefs.edit();
                editor.putString("alldelivery",result);
                editor.putString("username", mEmail);
                editor.putString("password", mPassword);
                editor.putString("statusicon", "true");
                editor.apply();

                Intent intent = new Intent(LoginActivity.this , MainActivity.class);
                startActivity(intent);
                finish();
            } else {
                //失敗した時の処理
                if(result.length()==3) {
                    if (Integer.parseInt(result) == 402) {
                        mEmailView.setError(getString(R.string.error_invalid_name));
                        mEmailView.requestFocus();
                    } else if (Integer.parseInt(result) == 403) {
                        mPasswordView.setError(getString(R.string.error_incorrect_password));
                        mPasswordView.requestFocus();
                    } else if (Integer.parseInt(result) == 404) {
                        mPasswordView.setError(getString(R.string.error_incorrect_password));
                        mPasswordView.requestFocus();
                    }
                }

            }
        }

        //cancelメソッドが呼び出された時に実行
        @Override
        protected void onCancelled() {
            mAuthTask = null;
            showProgress(false);
        }
    }
}

