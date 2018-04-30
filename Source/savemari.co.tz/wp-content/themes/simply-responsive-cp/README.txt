CREATING YOUR OWN "Thank you for your enquiry" PAGE

1. Go to your admin area - Pages->Add New and create a page with the title of "Thank you" (!!!important!!!), ensuring your permalink is: http://www.yourdomain.com/yourtheme/thank-you

2. Add your own thank you message and style it however you wish.

To start you off, you may use the following code in the content of your page
(please ensure you paste this code in the TEXT tab, not the VISUAL tab)...

<h2><span class="red">Thank you for your email enquiry.</span></h2>

<h2>We will get back to you shortly.</h2>
<p class="small">If you don't hear back from us within 48 hrs, please check your spam box.</p>

<span><a href="javascript:history.back()">&larr; Go Back</a></span>

There is an image you can upload, which you can see on the demo, sitting inside the images folder, called "tku.png". 

!!!Important!!! This is a copyrighted image and is ONLY to be used for the purposes of setting up your page. You will need to REPLACE the "tku.png" with your own image on your own website.






NON DISPLAY OF PRICE TAG WHEN NO PRICE IS ENTERED ON ADS AND FEATURED SLIDER

For this to function correctly, go to your admin area - Classipress->Form Layouts and set the price field as NOT REQUIRED (!important).






YOUTUBE & VIMEO VIDEO (optional)

1. Go to your admin area - Classipress->Custom Fields->Add New

Either
2a. Create a new custom YouTube ID field, ensuring the meta name is "cp_youtube_id"

Or
2b. Create a new custom Vimeo ID field, ensuring the meta name is "cp_vimeo_id"

You may create both video custom fields if you wish to allow the option for your customers to add video in either format.

Both Field Type(s): should be TEXT BOX to allow your customers to type in the Video ID (identifier).

You will need to instruct your customers or add a tooltip for your customers explaining that they ONLY need to add the video identifier and NOT the whole URL link, like so...

If the video link is http://www.youtube.com/watch?v=5PSNL1qE6VY

Your customers ONLY need to enter the last part (the identifier): 5PSNL1qE6VY


To help your customers, in your Field Tooltip you could put: 
YouTube ID (please enter the video ID only, not the full URL link)
and maybe give an example.

PS. You can change the custom field titles AFTER you have setup the custom fields.
eg: You may want to call them Youtube Identifier and Vimeo Identifier to make it clearer for your customers (up to you).

3. Next, create or edit your form layouts, Classipress->Form Layouts->
Either Add New form or edit existing form layouts to include the YouTube Video & Vimeo Video custom fields in any category of your choice. Then Simply add your new custom field(s) to your form(s).

4. That's it! Everything else is built into the child theme ready for you to use (if you so wish).

For those of you who wish to add video links to blog post and/or pages via the admin, you may do this by simply adding a shortcode as follows.

For a YouTube video:
[responsive-video identifier="5PSNL1qE6VY"]

For a Vimeo video:
[responsive-vimeo identifier="24715531"]






PRICE NEGOTIABLE (optional)

1. Go to your admin area - Classipress->Custom Fields->Add New

2. Create a new custom Price Negotiable field, ensuring the meta name is "cp_price_negotiable" (!!!important!!!)
Field Type: should be CHECKBOXES
Field Values: Yes

3. Next, create or edit your form layout: Classipress->Form Layouts->
Either Add New form or edit any existing form layouts to include the Price Negotiable custom field.

Simply add your new custom field to your form(s).
DO NOT MAKE THIS FIELD REQUIRED!

4. That's it! Everything else is built into the child theme ready for you to use (if you so wish).

For more info on this, see the original tutorial here:
http://forums.appthemes.com/classipress-general-discussion/***price-negotiable****-sign-listings-30450/






We hope these instructions are clear and cover everything you need to set up these extra features. If not, please do not hesitate to contact us: fabtalentmedia@gmail.com

Good luck with your website. It's not going to be easy, but anything that is worth worth while is going to take time and dedication. Be lucky.


