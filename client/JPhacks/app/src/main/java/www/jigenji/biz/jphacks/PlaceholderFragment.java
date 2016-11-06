package www.jigenji.biz.jphacks;

import android.app.ActionBar;
import android.graphics.Color;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v4.app.ListFragment;
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
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import java.util.ArrayList;


/**
 * Created by jigenjisk on 2016/10/28.
 */
public class PlaceholderFragment extends Fragment {

    private static final String ARG_SECTION_NUMBER = "section_number";


    public PlaceholderFragment() {
    }
    /**
     * Returns a new instance of this fragment for the given section
     * number.
     */
    // コンストラクタにkey:valueを渡したPlaceholderFragment型を返す
    public static PlaceholderFragment newInstance(int sectionNumber) {

        PlaceholderFragment fragment = new PlaceholderFragment();
        Bundle args = new Bundle();
        // key : value の保存
        args.putInt(ARG_SECTION_NUMBER, sectionNumber);
        // bundleをセット
        fragment.setArguments(args);
        return fragment;
    }






    //fragment の create
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {


        // inflater.inflate(int resource, ViewGroup root, ture or false), true=>指定したものをrootにする
        // fragment_main の親をcontainerにしない(false)だから=>RelativeLayoutを返す
//        View rootView = inflater.inflate(R.layout.activity_list_view, container, false); //戻り値の設定
//        TextView textView = (TextView) rootView.findViewById(R.id.section_label);
        // getArgument().getInt()==渡したbundle
        // getstring(文字列(そのid), 文字列に入れたい値(%sに相当))
//        textView.setText(getString(R.string.section_format, getArguments().getInt(ARG_SECTION_NUMBER)));


        return null;
    }
}


