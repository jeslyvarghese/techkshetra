//Javascript document

try
	{
		http_twitter = new ActiveXObject("Microsoft.XMLHTTP");
	}
catch(e)
	{
		http_twitter = new XMLHttpRequest();
	}
	

http_twitter.onreadystatechange = function(){
												if(http_twitter.readyState==4)
													{
														if(http_twitter.status==200)
															{
																json_object = parseJson(http_twitter.responseText);
																maxlength = json_object.results.length;
																results = json_object.results;
																initializeSystem();
																
															}
														else
															{
																//report error
															}
														}
												else
													{
														//need loading animation going on here
													}
												}
function getFeeds()
	{
		http_twitter.open("GET","twitter.php",true);
		http_twitter.send(null);
	}
function parseJson(text)
	{
		return jQuery.parseJSON(text);
	}
//The below variables are required for most functions


function retrievePics()
	{
		
		var imageURLArray = new Array(); 
		for(i=0;i<maxlength;i++)
			{
				imageURLArray[i] = results[i].profile_image_url;
			}
		return imageURLArray;
	}
function retrieveTweets()
	{
		var tweetsArray = new Array();
		for(i=0;i<maxlength;i++)
			{
				tweetsArray[i] = results[i].text;
			}
		return tweetsArray;
	}
function retrieveUsers()
	{
		var userArray = new Array();
		for(i=0;i<maxlength;i++)
			{
				userArray[i] = results[i].from_user;
			}
		return userArray;
	}
function createElements()
	{
		//$(document).add("<div id='container'></div>");
		/*$("#container").add("<div id='block1'></div>");
		$("#container").add("<div id='block2'></div>");
		$("#container").add("<div id='block3'></div>");
		$("#container").add("<div id='block4'></div>");
		$("#container").add("<div id='block5'></div>");
		$("#block1").add("<div id='image'></div><div id='tweet'></div>");
		$("#block2").add("<div id='image'></div><div id='tweet'></div>");
		$("#block3").add("<div id='image'></div><div id='tweet'></div>");
		$("#block4").add("<div id='image'></div><div id='tweet'></div>");
		$("#block5").add("<div id='image'></div><div id='tweet'></div>");*/
		$("#container").append("<div id='mask_top'></div>");
		$("#container").append("<div id='mask_bottom'></div>");
		$("#container").append("<div id='stage'></div>");
	}
function setCSS()
	{
		$("#container").css({'position':'absolute','top':'0','bottom':'0','left':'150px','margin':'auto','padding':'5px','height':'192px','width':'400px'});
		$("#mask_top").css({'position':'absolute','top':'0','height':'64px','width':'400px','opacity':'0.2'});
		$("#mask_bottom").css({'position':'absolute','bottom':'0','height':'64px','width':'400px','opacity':'0.2'});
		$("#stage").css({'position':'absolute','top':'0','bottom':'0','margin':'auto','height':'64px','width':'400px'});
	}
function switchBlocks()
	{
		$("#mask_top").html($('#stage').html());
		$("#stage").html($('#mask_bottom').html());
		$("#mask_bottom").html("<div id='mask_top_image' style='height: 48px; width: 48px; position: absolute; left: 10px; top: 0; bottom: 0; margin: auto;'><img  class='user_image' src="+img_url+"></div><div id='tweet' style='height: 64px; width: 310px; position: absolute; left: 70px; top: 0; bottom: 0; margin: auto; font-size: 10px; font-family: Verdana, Geneva, sans-serif;'>"+tweet_content+"</div>");
	}
function greyScaleTB()
	{
		$("#mask_bottom img").greyScale({fadeTime:10,reverse:false});
		$("#mask_top img").greyScale({fadeTime:10,reverse:false});
	}
function switchTweet(index)
	{
		img_url = img_url_array[index];
		tweet_content = "<i>"+text_array[index]+"</i><br/>"+"<b>-"+user_array[index];
	}
function initializeSystem()
	{
		
		img_url_array = retrievePics();
		text_array = retrieveTweets();
		user_array = retrieveUsers();
		createElements();
		setCSS();
		setInterval('runSystem()',5000);
	}
function runSystem()
	{
		if(tweetIndex>=maxlength)
			tweetIndex=0;
		switchTweet(tweetIndex++);
		switchBlocks();
		greyScaleTB();
	}

var json_object;
var maxlength;
var results;
var tweetIndex =0;
getFeeds();

