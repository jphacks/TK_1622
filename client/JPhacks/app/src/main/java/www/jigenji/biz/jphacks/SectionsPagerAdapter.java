package www.jigenji.biz.jphacks;

import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;

/**
 * Created by jigenjisk on 2016/10/28.
 */

/**
 * A {@link FragmentPagerAdapter} that returns a fragment corresponding to
 * one of the sections/tabs/pages.
 */
// ViewPagerの動作を作成
public class SectionsPagerAdapter extends FragmentPagerAdapter {

    public SectionsPagerAdapter(FragmentManager fm) {
        super(fm);
    }


    /**
     * ここでタブに表示する画面を設定する
     * positionには0から順のタブの番号が渡される。
     * なお、値を渡したいときはコメントアウトしてあるBundleを用いる。
     * また、ここでreturnのFragmentの型についてのエラーが出た場合は、import で[android.app.fragment]にしている可能性あり。support.v4に変えよう
     */
    @Override
    public Fragment getItem(int position) {
        if(position == 0){
            return ListFragment.newInstance(position + 1);
        }else if(position == 1){
            return GridFragment.newInstance(position + 1);
        }else{
            return StatusFragment.newInstance(position + 1);
        }
        // getItem is called to instantiate the fragment for the given page.
        // Return a PlaceholderFragment (defined as a static inner class below)
    }


    /**
     * タブの数を決定
     */

    @Override
    public int getCount() {
        // Show 3 total pages.
        return 3;
    }

    /**
     * タブのタイトルを決定
     */
    @Override
    public CharSequence getPageTitle(int position) {
        switch (position) {
            case 0:
                return "今日";
            case 1:
                return "全て";
            case 2:
                return "設定";
        }
        return null;
    }
}
