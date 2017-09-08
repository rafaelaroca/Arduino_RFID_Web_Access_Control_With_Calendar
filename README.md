# Arduino_RFID_Web_Access_Control_With_Calendar

Networked RFID Access Control System. Create to control the access of a laboratory of the Mechanicas Department of Federal University of São Carlos - UFSCar. 

Basic principle of operation: user passes a RFID 13MHz. Arduino reads the card and send its card ID to a remote server with a HTTP Request to arduino.php page. This page queries a MySQL database to check if such card is authorized or not (by day, by time and by auth flags). If it is authorized, it returns the word LIBERADO, Arduino receives it, shows on a LCD display and activates a relay to open the door. If the card is not authorized, the page arduino.php returns NEGADO and Arduino shows this message on the display and does not open the door.

While no user is trying to enter, the system shows the laboratory reservations and calendar/agenda on the display, fetched automatically from Google Calendar. See the other repository for more details.

![Device](IMG_20170511_114423541.jpg)
