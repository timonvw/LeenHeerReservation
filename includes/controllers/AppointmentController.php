<?php
class AppointmentController
{
    // public function __constructor()
    // {

    // }

    public function save($request/*, $file*/)    
    {
        $validator = new AppointmentValidator($request);
        
        //if(isset($file['file'])) $validator->validateFile($file);
        

        if($validator->getIsValid())
        {
            $appointment = $validator->getAppointment();
            return [$appointment->save()];
        }
        else
        {
            return $validator->getErrors();
        }
    }

    public function update($request, $object)
    {
        $object->firstname = $request['first'];
        $object->lastname = $request['last'];
        $object->email = $request['email'];
        $object->phone = $request['phone'];
        $object->subject = $request['subject'];
        $object->description = $request['description'];
        $object->date = $request['afspraak-date'];
        $object->time = $request['time'];

        return $object->update();
    }

    public function show()
    {
        $appointments = new Appointment();
        $appointments = $appointments->get("ORDER BY date, time");

        $appointmentsObj = [];

        if(!$appointments == "")
        {
            foreach($appointments as $appointment)
            {
                $appointmentsObj[] = new Appointment($appointment['firstname'],
                $appointment['lastname'],
                $appointment['email'],
                $appointment['phone_number'],
                $appointment['subject'],
                $appointment['description'],
                $appointment['date'],
                $appointment['time'],
                $appointment['id']);
            }
            return $appointmentsObj;
        }
        else
        {
            return "";
        }
    }

    public function getSubjects()
    {
        $info = new blockeddate();
        return $info->getAllSubjects();
    }

    /*SELECT appointments.*, treatments.name AS treatment_name, accounts.name AS account_name
    FROM appointments
    LEFT JOIN treatments ON appointments.treatment_id = treatments.id
    LEFT JOIN accounts ON appointments.account_id = accounts.id*/
}
?>