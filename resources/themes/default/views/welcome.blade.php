@extends('layouts.master')

@section('content')
 <div class="login-logo" style="padding-top:-20px;"><img src="{{ asset ("/assets/themes/default/img/fms.png") }}" alt="User Image">
     <br><h1>{{ trans('general.text.home-header') }}</h1>
     </div>
<div class="box-body">FMS is a file messaging and logging software that allows users to pass files to one another without keeping a copy on their local device. The system has the following modules. 
</div>
<div class="box-body">There are 7 modules (functional blocks):<br>
A.  MyDesk<br>
B.  Request File<br>
C.  Actions<br>
D.  File Tracking<br>
E.  Contacts<br>
F.  Profile<br>
G.  Admin<br>
</div>
<div class="box-body">
There are 4 Features (services)<br>
A.  Messaging Service<br>
a.  Comment, Notification, Attachment, Passing= Mod A<br>
b.  Requesting File from current holder=Mod B<br>
B.  Logging Service<br>
a.  Office Activity Logging: Office Actions Log =Mod C<br>
b.  Global File Movement Loggin: File Tracking =Mod D <br>
C.  Authentication Service <br>
a.  User login authentication (password)= Mod F<br>
b.  User Transaction authentication (PIN)= Mod F<br>
c.  User & File Clearance Levels matching<br>
d.  Admin privileges = Mod G<br>
D.  File Management Service<br>
a.  Page Preview and thumbnails<br>
b.  File Auto-Numbering System<br>
c.  Folder management<br>
d.  “Move To” function for Registry= Mod G<br>
</div>


<div class="box-body">
1.  My Desk: all files passed to user, appears here in a threaded view. Once treated and passed, it disappears from here and appear under My Actions. No duplication of same file, instead update all comments/Treats. Right under the file is the Treat bar like where facebook comment is. Under this module, user can:<br>
a.  See Received files/feed: it displays the first page of the file sent and the other pages in thumbnail <br>
b.  Upload New File: Users to upload files from their desktop or storage to the app. But only the first page is displayed and others are thumbnails <br>
i.  File subject<br>
ii. File number (system generated: AgencyName/Unit/SubjectNumber/File Sequence)<br>
iii.    Date<br>
iv. Clearance Level (default is 1)<br>
c.  Treat Icon: opens a comment form <br>
i.  “To” field for single or multiple recipients: user CANNOT type recipient id instead can only SELECT the user. Default contact list are users groups set in the contacts menu <br>
ii. Text area<br>
iii.    Attach additional files. <br>
iv. “Return File” (only with a PIN). Back to sender<br>
v.   “Pass” button which check if the file clearance and user clearance match, if not, it will decline and if yes, it will prompt the user to enter his PIN (a 4 digit number). If it is correct, it will pass the file to the selected users, if wrong, it will decline<br>
vi. Each comment automatically adds sender’s picture, name, position, date, and time under the comment 
<br>vii.    Once successful, a copy of any new file is stored in the default library folder “Opening”. Additional files will inherit the properties of the originating file
<br>viii.   Recipients will see a notification (red and sound) on their user page MyDesk icon
<br>ix. Once you pass a file, it will appear on the recipient’s MyDesk and append a pending status until recipient logs into the system then it will disappear from your desk. If you have treated all your files, your MyDesk will be empty
<br>x.   The last person to act on a file will pass to “Registry” when he finishes, which takes the file off the user’s desk to Registry Desk, and Registry then clicks a button called “Move To” which shows him all the category folders in the library and he chooses where the file should move to. When the file gets there, it will auto create a folder for its self with the file subject as file folder name residing inside file category folder  and disappear from registry desk
</div>
<div class="box-body">2.    Contacts: this is a list of all contacts on the system. User sees them in this order
<br>a.  contacts in my unit and my agency
<br>b.  other contacts based on categories
<br>c.  User can send a file to any user, category or user under a category
<br>3.  Actions: this module logs every successful “pass” to the office/position. It has two tabs and a search bar for filtering
<br>a.  MyActions: this is a list of all files you ever passed or worked on in your office. You can see the list of file subject and the date you passed it out but to work on it again or to make it appear on your MyDesk, you have to click “request it from the current holder”  and the holder will see your request on his MyDesk and he can either “Grant” or “Decline” grant passes the file to you after PIN check and decline sends you a short message declining. Maximum display is 20 but you can next
</div>
<div class="box-body">b.    MyOfficeActions: this is a log of all the files your office worked on and the dates. You can click it to request from current holder. Maximum display is 20 but you can next
</div>
<div class="box-body">
4.  File Tracking: this module shows a log of all files with the “from” and “To” fields and the date. It updates that “from and To” fields as they change but only shows to users who have that file in their user activity log. Each file has 3 information
<br>a.  From user
<br>b.  Date passed
<br>c.  To user</div>
<div class="box-body">
5.  Request file: clicking this button will open a form that automatically selects user name “Registry” and you just type the file description and click “Pass” then prompt for PIN, verifies PIN and it goes. “registry” will see it on “MyDesk” and search the file in the catalogue library and simply “Pass” to you 
</div><div class="box-body">6.  Login: this is on the landing page for username and password, once logged in, it is at the top right corner and user can logout 
</div>



<div class="box-body">
7.  Profile
<br>a.  Checkbox for Show contacts in my unit and my agency
<br>b.  Checkbox for Show other contacts based on categories
<br>c.  User can send a file to any user, category or user under a category
<br>d.  User cannot change his name
<br>e.  User cannot change his position
<br>f.  User CAN CHANGE his PIN
<br>g.  User CAN CHANGE his Password
<br>h.  Use can set DP
<br>i.  System defined “idle time” for auto logout
</div>
<div class="box-body">
General notes
<br>1.  Recipient can also print any page and physically comment and Treat on it and scan it to his system and upload as new version. So there is physical comment on paper that is scanned and there is online commenting which all require a PIN to Pass to another user
<br>2.  Every file searched will be displayed with all comments and profiles ever made on it.
<br>3.  Only admin can create users and set username, password and default PIN to 0000 users will change it to theirs.
</div>
<div class="box-body">
Admin / User Rights and Mgt

<br>1.  Admin will create organization and accounts using a reference mail domain e.g peter@kdsg.gov.ng, ahmed@kdsg.gov.ng meaning peter@gmail.com will fail to register. So even admin cannot register someone without an email on that domain
<br>a.  To bind the reference mail server for the organization, set the domain name and let it apply to all user creations with only user given names varying and domain greying out

<br>b.  User profile is completely set by admin and a verification mail is sent to the users email and the user clicks the link and completes registration with password and PIN change.

<br>2.  Users ID is their email and MUST be same domain as admin So outsiders cannot use the system. 

<br>3.  Admin will set password and default PIN which users can change latter
<br>
4.  Users can set their DP

<br>5.  Set security clearance levels, agency, unit(department) and define for each user

<br>6.  Desk and MyActions are “tied” to user’s position/office NOT to usernames so if that office is allocated to someone else, that user will see all the desk and myaction contents. It would simply mean there has been a transfer of power Essentially, its an office-to-office collaboration not person-to-person

<br>7.  Admin will set official position for users which they cannot change, only admin can change that

<br>8.  Admin will create document library categories which users can choose from when initiating a memo

<br>9.  No user can delete any file 

<br>10. Sub-admin should be able to download any file but system will log the report

<br>11. A licensing system to allow us set maximum number of users. We generate a key for the admin which determines the maximum allowable users that can be created on the server
<div class="box-body">

@endsection
