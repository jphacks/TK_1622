package www.jigenji.biz.jphacks;

import android.app.ActionBar;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;

import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.support.v4.view.ViewPager;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;

import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import java.util.ArrayList;

/**
 * Created by jigenjisk on 2016/10/28.
 */
public class StatusFragment extends Fragment{

    private static final String ARG_SECTION_NUMBER = "section_number";

    public StatusFragment() {
    }
    /**
     * Returns a new instance of this fragment for the given section
     * number.
     */
    // コンストラクタにkey:valueを渡したPlaceholderFragment型を返す
    public static StatusFragment newInstance(int sectionNumber) {

        StatusFragment fragment = new StatusFragment();
        Bundle args = new Bundle();
        // key : value の保存
        args.putInt(ARG_SECTION_NUMBER, sectionNumber);
        // bundleをセット oncreateの時は通る
        fragment.setArguments(args);
        return fragment;
    }




    //fragment の create
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {



        View rootView = inflater.inflate(R.layout.fragment_status, container, false); //戻り値の設定

        final LinearLayout linear = (LinearLayout) rootView.findViewById(R.id.DLiner);
        final TextView DefaultText = (TextView) rootView.findViewById(R.id.DTextView2);

        Button DefaultButton = (Button) rootView.findViewById(R.id.default_button);



        SharedPreferences prefsd = getPrefs("SaveData", getActivity());
        int str = prefsd.getInt("default", 0);
        String pas = prefsd.getString("time1d", "");
        String all = prefsd.getString("time2d", "");

        DefaultText.setText(Functions.Default(str,pas,all));


        DefaultButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                SharedPreferences prefsd2 = getPrefs("SaveData", getActivity());
                SharedPreferences.Editor editor = prefsd2.edit();
                Snackbar.make(linear, "開始時間を設定してください", Snackbar.LENGTH_SHORT).show();
                TimePickerDialogFragmentD timePicker = new TimePickerDialogFragmentD();
                timePicker.show(getFragmentManager(), "timePicker");
                Snackbar.make(linear, "終了時間を設定してください", Snackbar.LENGTH_SHORT).show();
                TimePickerDialogFragmentD2 timePicker2 = new TimePickerDialogFragmentD2();
                timePicker2.show(getFragmentManager(), "timePicker");
                editor.putInt("default",1);
                editor.apply();

                int str = prefsd2.getInt("default", 0);
                String pas = prefsd2.getString("time1d", "");
                String all = prefsd2.getString("time2d", "");

                DefaultText.setText(Functions.Default(str,pas,all));

            }
        });

        return rootView;
    }

    private static SharedPreferences getPrefs(String string,Context context) {
        return context.getSharedPreferences(string, Context.MODE_PRIVATE);
    }
}
