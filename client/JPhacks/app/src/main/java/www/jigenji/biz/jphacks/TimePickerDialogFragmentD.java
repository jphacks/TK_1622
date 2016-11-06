package www.jigenji.biz.jphacks;

import android.app.Dialog;
import android.app.TimePickerDialog;
import android.content.Context;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.v4.app.DialogFragment;
import android.widget.TimePicker;

import java.util.Calendar;

/**
 * Created by jigenjisk on 2016/11/06.
 */
public class TimePickerDialogFragmentD extends DialogFragment implements TimePickerDialog.OnTimeSetListener {

    @Override
    public Dialog onCreateDialog(Bundle savedInstanceState) {
        final Calendar c = Calendar.getInstance();
        int hour = c.get(Calendar.HOUR_OF_DAY);
        int minute = c.get(Calendar.MINUTE);

        TimePickerDialog timePickerDialog = new TimePickerDialog(getActivity(), this, hour, minute, true);

        return timePickerDialog;
    }

    public void onTimeSet(TimePicker view, int hourOfDay, int minute) {
        SharedPreferences prefstp = getPrefs("SaveData", getActivity());
        SharedPreferences.Editor editortp = prefstp.edit();
        editortp.putString("time1d", String.valueOf(hourOfDay) + ":" +String.valueOf(minute));
        editortp.apply();

    }

    private static SharedPreferences getPrefs(String string,Context context) {
        return context.getSharedPreferences(string, Context.MODE_PRIVATE);
    }

}
