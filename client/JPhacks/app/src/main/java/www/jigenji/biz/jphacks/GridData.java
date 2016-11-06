package www.jigenji.biz.jphacks;

import android.graphics.Bitmap;

/**
 * Created by jigenjisk on 2016/11/03.
 */
public class GridData {
    private Bitmap gridIcon_;
    private String gridTitle_;
    private String gridValue_;
    private String gridCompany_;


    public void setgridIcon(Bitmap image) {
        gridIcon_ = image;
    }

    public Bitmap getgridIcon() {
        return gridIcon_;
    }

    public void setgridCompany(String text) {
        gridCompany_ = text;
    }

    public String getgridCompany() {
        return gridCompany_;
    }


    public void setgridTitle(String text) {
        gridTitle_ = text;
    }

    public String getgridTitle() {
        return gridTitle_;
    }

    public void setgridValue(String text) {
        gridValue_ = text;
    }

    public String getgridValue() {
        return gridValue_;
    }

}
