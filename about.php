<?php
$user_agent = $_SERVER['HTTP_USER_AGENT'];
date_default_timezone_set('Asia/Kolkata'); 
function getOS() { 
    global $user_agent;
    $os_platform  = "Unknown OS Platform";
    $os_array     = array(
                          '/windows nt 10/i'      =>  'Windows 10',
                          '/windows nt 6.3/i'     =>  'Windows 8.1',
                          '/windows nt 6.2/i'     =>  'Windows 8',
                          '/windows nt 6.1/i'     =>  'Windows 7',
                          '/windows nt 6.0/i'     =>  'Windows Vista',
                          '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                          '/windows nt 5.1/i'     =>  'Windows XP',
                          '/windows xp/i'         =>  'Windows XP',
                          '/windows nt 5.0/i'     =>  'Windows 2000',
                          '/windows me/i'         =>  'Windows ME',
                          '/win98/i'              =>  'Windows 98',
                          '/win95/i'              =>  'Windows 95',
                          '/win16/i'              =>  'Windows 3.11',
                          '/macintosh|mac os x/i' =>  'Mac OS X',
                          '/mac_powerpc/i'        =>  'Mac OS 9',
                          '/linux/i'              =>  'Linux',
                          '/ubuntu/i'             =>  'Ubuntu',
                          '/iphone/i'             =>  'iPhone',
                          '/ipod/i'               =>  'iPod',
                          '/ipad/i'               =>  'iPad',
                          '/android/i'            =>  'Android',
                          '/blackberry/i'         =>  'BlackBerry',
                          '/webos/i'              =>  'Mobile'
                    );
    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $os_platform = $value;

    return $os_platform;
}
function getBrowser() {
    global $user_agent;
    $browser        = "Unknown Browser";
    $browser_array = array(
                            '/msie/i'      => 'Internet Explorer',
                            '/firefox/i'   => 'Firefox',
                            '/safari/i'    => 'Safari',
                            '/chrome/i'    => 'Chrome',
                            '/edge/i'      => 'Edge',
                            '/opera/i'     => 'Opera',
                            '/netscape/i'  => 'Netscape',
                            '/maxthon/i'   => 'Maxthon',
                            '/konqueror/i' => 'Konqueror',
                            '/mobile/i'    => 'Handheld Browser'
                     );
    foreach ($browser_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $browser = $value;
    return $browser;
}
function ip_get($allow_private = false)
{
  $proxy_ip = ['127.0.0.1'];
  $header = 'HTTP_X_FORWARDED_FOR';
  if(ip_check($_SERVER['REMOTE_ADDR'], $allow_private, $proxy_ip)) return $_SERVER['REMOTE_ADDR'];
  if(isset($_SERVER[$header]))
  {
    $chain = array_reverse(preg_split('/\s*,\s*/', $_SERVER[$header]));
    foreach($chain as $ip) if(ip_check($ip, $allow_private, $proxy_ip)) return $ip;
  }
   return null;
}
function ip_check($ip, $allow_private = false, $proxy_ip = [])
{
  if(!is_string($ip) || is_array($proxy_ip) && in_array($ip, $proxy_ip)) return false;
  $filter_flag = FILTER_FLAG_NO_RES_RANGE;
  if(!$allow_private)
  {
    if(preg_match('/^127\.$/', $ip)) return false;
    $filter_flag |= FILTER_FLAG_NO_PRIV_RANGE;
  }
  return filter_var($ip, FILTER_VALIDATE_IP, $filter_flag) !== false;
}
try {
    $user_os        = getOS();
    $user_browser   = getBrowser();
    $cname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $ip = ip_get();
    $fp = fopen('ip.txt', 'a');
    $json     = file_get_contents("http://ip-api.com/json/$ip");
    $json     = json_decode($json, true);
    $country  = $json['country'];
    $region   = $json['regionName'];
    $city     = $json['city'];
    $zip     = $json['zip'];
    $isp     = $json['isp'];
    $str = "\n".$cname."  ".strval($ip)." ".$city." ".$region." ".$country." ".$zip." ".$isp." ".$user_os." ".$user_browser." ".date("h:i:sa")." ". date("d/m/Y")."\n";
    fwrite($fp,$str);  
    fclose($fp);
}
catch(Exception $e) {
}
?>

<!DOCTYPE html>
<html lang="en">
   <meta http-equiv="content-type" content="text/html;charset=utf-8" />
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="Final Year B.C.A Student at Maharaja Sayajirao University of Baroda | IoT and Java Web Developer | CEH | Transcriptionist | Freelancer">
      <meta name="author" content="Ebenezer Isaac">
      <link rel="icon" type="image/png" href="img/favicon.ico"/>
      <meta name="theme-color" content="#1565C0">
      <meta name="google-site-verification" content="GUFBW5od3qQmuDAG8G1_GbYftsnLK9i2bgWdOxthNlQ" />
	  <meta keywords='keywords' content='ebenezer isaac, ebenezer, isaac ,indian ceh, iot developer, java developer, msu baroda, cerberus, mycrochips, ebenezer tirunelveli'>
      <title>Ebenezer Isaac | CEH | IoT and Java Web Developer | MSU Baroda</title>
      <meta property="og:title" content="Ebenezer Isaac | CEH | IoT Developer" />
      <meta property="og:site_name" content="Click To Know More">
      <meta property="og:url" content="https://ebenezer-isaac.com/index.php" />
      <meta property="og:description" content="Final Year B.C.A Student">
      <meta property="og:image" content="https://ebenezer-isaac.com/img/profile.jpg">
      <meta property="og:image:width" content="686" />
      <meta property="og:image:height" content="788" />
      <meta property="og:type" content="website" />
      <link defer href="css/tidy.css" rel="stylesheet">
      <link defer href="fontawesome-free/css/all.min.css" rel="stylesheet">
      <style>
      .disable {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
      </style>
   </head>
   <body id="page-top">
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top disable" id="sideNav">
         <a class="navbar-brand js-scroll-trigger" href="#page-top">
         <span class="d-block d-lg-none">Ebenezer Isaac</span>
         <span class="d-none d-lg-block">
			<picture>
				<source defer class="img-fluid rounded-circle mx-auto mb-2" srcset="img/profile.webp" type="image/webp">
				<img class="img-fluid img-profile rounded-circle mx-auto mb-2" src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="img/profile.jpg">
			</picture>
         </span>
         </a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
               <li class="nav-item">
                  <a class="nav-link js-scroll-trigger" href="#about">About</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link js-scroll-trigger" href="#experience">Tech - Experience</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link js-scroll-trigger" href="#education">Education</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link js-scroll-trigger" href="#skills">Skills</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link js-scroll-trigger" href="#interests">Interests</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link js-scroll-trigger" href="#awards">WorkShops</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link js-scroll-trigger" href="#projects">Projects</a>
               </li>
            </ul>
         </div>
      </nav>
      <div class="container-fluid p-0">
         <section class="resume-section p-3 p-lg-5 d-flex d-column" id="about">
            <div class="my-auto">
               <h1 class="mb-0 disable">Ebenezer
                  <span class="text-primary disable">Isaac</span>
               </h1>
               <div class="subheading mb-0 disable">
                   Tirunelveli, Tamil Nadu, India
               </div>
               <div class="subheading mb-5">
                   <a href="mailto:contact@ebenezer-isaac.com">contact@ebenezer-isaac.com</a>
               </div>
               <p class="lead justify-content-center disable">Final Year B.C.A Student at Maharaja Sayajirao University of Baroda (Gujarat) </p>
               <p class="lead justify-content-center disable">Certified Ethical Hacker. IoT and Java Web Developer. Freelancer.<br> Always seeking for opportunities to learn new things.</p>
               <br>
               </p>
               <div class="social-icons disable">
                  <a href="https://github.com/ebenezerv99" target="_blank">
                  <i class="fab fa-github"></i>
                  </a>
                  <a href="https://stackoverflow.com/users/11380610/ebenezer-isaac" target="_blank">
                  <i class="fab fa-stack-overflow"></i>
                  </a>
                  <a href="https://twitter.com/ebenezerv99" target="_blank">
                  <i class="fab fa-twitter"></i>
                  </a>
               </div>
            </div>
         </section>
         <hr class="m-0">
         <section class="resume-section p-3 p-lg-5 d-flex flex-column disable" id="experience">
            <div class="my-auto">
               <h2 class="mb-5">Tech - Experience</h2>
               <div class="resume-item d-flex flex-column flex-md-row mb-5">
                  <div class="resume-content mr-auto">
                     <h3 class="mb-0">Chief Technology Officer &amp; Founder</h3>
                     <div class="subheading mb-3">MycroChips (still in initiation stage)</div>
                     <p class="justify-content-center">A Startup focused on making lives easier with automation.</p>
                  </div>
                  <div class="resume-date text-md-right">
                     <span class="text-primary">Current</span>
                  </div>
               </div>
               <div class="resume-item d-flex flex-column flex-md-row mb-5">
                  <div class="resume-content mr-auto">
                     <h3 class="mb-0">Java Web Developer</h3>
                     <div class="subheading mb-3">Cerberus</div>
                     <p class="justify-content-center"> Developed back-end for Attendance Management System. The System was made as part of my 5th Semester Project with my University's Computer Application's Department acting as live client. The System had full-fledged Student Management facilities like adding Classes, Subjects, Batches. As Part of Attendance Management, the website had a progressive Timetable Management System to oversee the Attendance of Students. The website also had a Student login from where students can view their current Attendance percentage in their respective subjects. </p>
                  </div>
                  <div class="resume-date text-md-right">
                     <span class="text-primary">April 2019 - November 2019</span>
                  </div>
               </div>
               <div class="resume-item d-flex flex-column flex-md-row mb-5">
                  <div class="resume-content mr-auto">
                     <h3 class="mb-0">Raspberry-Pi Developer</h3>
                     <div class="subheading mb-3">Cerberus</div>
                     <p class="justify-content-center"> Due to processing incapabilities of an Arduino based System (described below). A Raspberry-Pi Zero based Attendance Reporting System was developed which worked in sync with the Web Application mentioned above. The Raspberry-Pi interfaced with Ethernet, SD card, Fingerprint Scanner, LCD Module, Keypad and a Real Time Clock to feed synchronous data for the website. As an additional feature to the Arduino based System, the fingerprint templates could now be stored in a remote database and synced when needed. Increasing the capacity of the Fingerprint Sensor from just 200 to virtually unlimited.</p>
                  </div>
                  <div class="resume-date text-md-right">
                     <span class="text-primary">August 2019 - November 2019</span>
                  </div>
               </div>
               <div class="resume-item d-flex flex-column flex-md-row mb-5">
                  <div class="resume-content mr-auto">
                     <h3 class="mb-0">Arduino Developer</h3>
                     <div class="subheading mb-3">Cerberus</div>
                     <p class="justify-content-center"> Developed full-fledged Attendance Reporting System which worked in sync with the Web Application mentioned above. The Arduino interfaced with Ethernet, SD card, Fingerprint Scanner, LCD Module, Keypad and a Real Time Clock to feed synchronous data for the website.</p>
                  </div>
                  <div class="resume-date text-md-right">
                     <span class="text-primary">April 2019 - August 2019</span>
                  </div>
               </div>

               <div class="resume-item d-flex flex-column flex-md-row mb-5">
                  <div class="resume-content mr-auto">
                     <h3 class="mb-0">Front-End Developer</h3>
                      <div class="subheading mb-3"> Medstore Limited</div>
                     <p class="justify-content-center"> Built a website from scratch with a basic contact form. The website was live on www.medstore.uk.ltd . The website was made as a freelancing project for a UK based Pharmaceutical Company which is now out of commission.
                     </p>
                  </div>
                  <div class="resume-date text-md-right">
                     <span class="text-primary"> April 2018 to June 2019</span>
                  </div>
               </div>
            </div>
         </section>
         <hr class="m-0">
         <section class="resume-section p-3 p-lg-5 d-flex flex-column disable" id="education">
            <div class="my-auto">
               <h2 class="mb-5">Education</h2>
               <div class="resume-item d-flex flex-column flex-md-row mb-5">
                  <div class="resume-content mr-auto">
                     <h3 class="mb-0">Maharaja Sayajirao University of Baroda</h3>
                     <div class="subheading mb-3">Bachelor of Computer Applications</div>
                     <p class="justify-content-center">
                        <strong> Relevant exams included in my study plan: <br></strong>
                        Java Web Programming, Android Programming, Artificial Intelligence, <br>Computer Networks, Graphic Designing, Flash Animation
                        <br><strong>Current projects:<br></strong>
                        Attendance Management System
                     </p>
                  </div>
                  <div class="resume-date text-md-right">
                     <span class="text-primary">June 2017 - Present</span>
                  </div>
               </div>
               <div class="resume-item d-flex flex-column flex-md-row mb-5">
                  <div class="resume-content mr-auto">
                     <h3 class="mb-0">EC - Council</h3>
                     <div class="subheading mb-3">Certified Ethical Hacking v10</div>
                     <p class="justify-content-center">
                        The Certified Ethical Hacker (C|EH v10) program is a trusted and respected ethical hacking training Program that any information security professional will need. Since its inception in 2003, the Certified Ethical Hacker has been the absolute choice of the industry globally.
                     </p>
                  </div>
                  <div class="resume-date text-md-right">
                     <span class="text-primary">April 2019 - Present</span>
                  </div>
               </div>
               <div class="resume-item d-flex flex-column flex-md-row">
                  <div class="resume-content mr-auto">
                     <h3 class="mb-0">Duke University</h3>
                     <div class="subheading mb-3">Programming Foundation in JavaScript, HTML and CSS with Honors</div>
                  </div>
                  <div class="resume-date text-md-right">
                     <span class="text-primary">September 2018</span>
                  </div>
               </div>
               <div class="resume-item d-flex flex-column flex-md-row">
                  <div class="resume-content mr-auto">
                     <h3 class="mb-0">Touch Typing</h3>
                     <div class="subheading mb-3">70 - 100 WPM</div>
                  </div>
                  <div class="resume-date text-md-right">
                     <span class="text-primary">January 2019</span>
                  </div>
               </div>
               <div class="resume-item d-flex flex-column flex-md-row">
                  <div class="resume-content mr-auto">
                     <h3 class="mb-0">Delhi Public School</h3>
                     <div class="subheading mb-3">Senior Secondary Education</div>
                  </div>
                  <div class="resume-date text-md-right">
                     <span class="text-primary">March 2017</span>
                  </div>
               </div>
            </div>
         </section>
         <hr class="m-0">
         <section class="resume-section p-3 p-lg-5 d-flex flex-column disable" id="skills">
            <div class="my-auto">
               <h2 class="mb-5">Skills</h2>
               <div class="subheading mb-3">Programming Languages &amp; Tools</div>
               <ul class="list-inline dev-icons">
                  <li class="list-inline-item">
                     <i class="fab fa-python"></i>
                  </li>
                  <li class="list-inline-item">
                     <i class="fab fa-java"></i>
                  </li>
                  <li class="list-inline-item">
                     <i class="fab fa-android"></i>
                  </li>
                  <li class="list-inline-item">
                     <i class="fab fa-html5"></i>
                  </li>
                  <li class="list-inline-item">
                     <i class="fab fa-css3-alt"></i>
                  </li>
                  <li class="list-inline-item">
                     <i class="fab fa-linux"></i>
                  </li>
                  <li class="list-inline-item">
                     <i class="fab fa-adobe"></i>
                  </li>
                  <li class="list-inline-item">
                     <i class="fab fa-raspberry-pi"></i>
                  </li>
               </ul>
               And also:
               <ul class="fa-ul mb-2">
                  <li>
                     <i class="fa-li fa fa-check"></i>
                     C, C++ and system programming
                  </li>
                  <li>
                     <i class="fa-li fa fa-check"></i>
                     Network and Web applications
                  </li>
                  <li>
                     <i class="fa-li fa fa-check"></i>
                     Arduino, Raspberry-Pi and IoT development
                  </li>
                  <li>
                     <i class="fa-li fa fa-check"></i>
                     Graphic Designing and Flash Animation Development
                  </li>
                  <li>
                     <i class="fa-li fa fa-check"></i>
                     Interested in Machine Learning and Data Science
                  </li>
               </ul>
               <div class="subheading mb-3">Languages</div>
               <ul class="fa-ul mb-0">
                  <li>
                     <i class="fa-li fa fa-check"></i>
                     English - Working Proficiency
                  </li>
                  <li>
                     <i class="fa-li fa fa-check"></i>
                     Hindi - Working Proficiency
                  </li>
                  <li>
                     <i class="fa-li fa fa-check"></i>
                     Gujarati - GSEB SSC Exam
                  </li>
                  <li>
                     <i class="fa-li fa fa-check"></i>
                     French - University Level - 2 Exam
                  </li>
                  <li>
                     <i class="fa-li fa fa-check"></i>
                     Tamil - Native
                  </li>
                  <li>
                     <i class="fa-li fa fa-check"></i>
                     Telugu - Novice
                  </li>
                  <li>
                     <i class="fa-li fa fa-check"></i>
                     Malayalam - Novice
                  </li>
               </ul>
            </div>
         </section>
         <hr class="m-0">
         <section class="resume-section p-3 p-lg-5 d-flex flex-column disable" id="interests">
            <div class="my-auto">
               <h2 class="mb-5">Interests</h2>
               <p class="justify-content-center">Apart from being a developer, I enjoy most of my time playing PC games and I spend a large amount of my free time exploring the latest technology, trying to implement them in my own weird way. I sometimes make projects related to IoT for fun and spend the rest of my time customizing my laptops and workspace.
               </p>
               <p class="justify-content-center">Technology aside, due to my artistic mind I often do some shitty paintings and  create models out of cardboard. I recently made a mechanically working Desert Eagle purely out of cardboard, paper and rubber-bands</p>
            </div>
         </section>
         <hr class="m-0">
         <section class="resume-section p-3 p-lg-5 d-flex flex-column" id="awards">
            <div class="my-auto">
               <h2 class="mb-5">WorkShops</h2>
               <div class="resume-item d-flex flex-column flex-md-row mb-5">
                  <div class="resume-content mr-auto">
                     <h3 class="mb-0">Google Dev Group's DevFest</h3>
                     <div class="subheading mb-3">Vadodara</div>
                  </div>
                  <div class="resume-date text-md-right">
                     <span class="text-primary">September 2019</span>
                  </div>
               </div>
               <div class="resume-item d-flex flex-column flex-md-row mb-5">
                  <div class="resume-content mr-auto">
                     <h3 class="mb-0">TechFest, IIT Bombay</h3>
                     <div class="subheading mb-3">EthicalHacking, Cloud Computing, Deep Learning</div>
                  </div>
                  <div class="resume-date text-md-right">
                     <span class="text-primary">December 2018</span>
                  </div>
               </div>
               <div class="resume-item d-flex flex-column flex-md-row mb-5">
                  <div class="resume-content mr-auto">
                     <h3 class="mb-0">BITA Technovative</h3>
                     <div class="subheading mb-1">Android Application</div>
                     Won Android App Master Awarding for developing Music Player from scratch in under 2 hrs.</p>
                  </div>
                  <div class="resume-date text-md-right">
                     <span class="text-primary">January 2018</span>
                  </div>
               </div>
            </div>
      </div>
      </section>
      <section class="resume-section p-3 p-lg-5 d-flex flex-column disable" id="projects">
         <div class="my-auto">
            <h2 class="mb-5">Projects</h2>
            <div class="subheading mb-3">This Section is under construction</div>
            <p class="justify-content-center">I am planning to share source code to all my software projects on github  and write up a tutorial to replicate it easily. I will hopefully make this section available after my exams.</p>
         </div>
      </section>
      </div>
      <script src="jquery/jquery.min.js"></script>
      <script defer src="js/bootstrap.bundle.min.js"></script>
      <script defer src="jquery-easing/jquery.easing.min.js"></script>
      <script defer src="js/resume.min.js"></script>
      <script>
        function init() {
            var imgDefer = document.getElementsByTagName('img');
            for (var i=0; i<imgDefer.length; i++) {
                    if(imgDefer[i].getAttribute('data-src')) {
                    imgDefer[i].setAttribute('src',imgDefer[i].getAttribute('data-src'));
            } } }
        window.onload = init;
        </script>
   </body>
</html>
