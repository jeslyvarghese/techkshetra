// JavaScript Document

//This file act as an adaptor for the registration frontend

function Login(mail,password)
	{
		$.ajax(
			   	{
					type:"GET",
					url:"frontend/inferno.php?action=login",
					data:{Mail:mail,Password:password},
					cache:false,
					success:function(message)
											{
												
												if(message==1)
													{
														GetMyEvents();
													}
												else if(message==2)
													{
														alert("Login Failed! Wrong Password");
													}
												else if(message==3)
													{
														alert("Login Failed! Wrong Mail Id");
													}
												else
													{
														alert("Server Error")
													}
											}
				}
			   );
	}

function UserRegistration(mail,firstname,lastname,phone,college)
	{
				$.ajax(
			   	{
					type:"GET",
					url:"frontend/inferno.php?action=register",
					data:{Mail:mail,FirstName:firstname,LastName:lastname,Phone:phone,College:college},
					cache:false,
					success:function(message)
											{
												alert(message);
												if(message==1)
													{
														$("#SignUp").html("Registration Successful! Please Check your e-mail");
													}
												else if(message==0)
													{
														$("#SignUp").html("Sign Up Failed");
														//actions on a failed registration
													}
												/*else if(message==3)
													{
														//actions on a failed mail id
													}*/
												else
													{
														//alert("Server Error!"+message);
														//sevrver error
													}
											}
				}
			   );
	}
	
function ChangePassword(mail,oldpassword,newpassword)
	{		
		$.ajax(
			   	{
					type:"GET",
					url:"frontend/inferno.php?action=changepassword",
					data:{Mail:mail,OldPassword:oldpassword,NewPassword:newpassword},
					cache:false,
					success:function(message)
											{
												if(message==1)
													{
														alert("Succes!:");
														//actions on a succesful login
													}
												else if(message==2)
													{
														alert(message);
														//actions on a failed password
													}
												else if(message==3)
													{
														alert(message);
														//actions on a failed mail id
													}
												else
													{
														//sevrver error
													}
											}
				}
			   );
		}

function RequestResetPassword(mail)
	{
				$.ajax(
			   	{
					type:"GET",
					url:"frontend/inferno.php?action=reset",
					data:{Mail:mail},
					cache:false,
					success:function(message)
											{
												if(message==1)
													{
														//actions on a succesful login
													}
												else if(message==2)
													{
														//actions on a failed password
													}
												else if(message==3)
													{
														//actions on a failed mail id
													}
												else
													{
														//sevrver error
													}
											}
				}
			   );
	}
function ToggleParticipation(eventid,eventtype)
	{
				$.ajax(
			   	{
					type:"GET",
					url:"frontend/inferno.php?action=registration",
					data:{EventID:eventid,EventType:eventtype},
					cache:false,
					success:function(message)
											{
												if(message=="Participating")
													{
														alert("Participating");
														//actions on a succesful login
													}
												else if(message=="Participate")
													{
														alert("Not Participating"+message);
														//actions on a failed password
													}
												/*else if(message==3)
													{
														//actions on a failed mail id
													}*/
												else
													{
														alert("Server Error"+message);
														//sevrver error
													}
											}
				}
			   );
	}
	
function GetMyEvents()
	{
				$.ajax(
			   	{
					url:"frontend/inferno.php?action=events",
					cache:false,
					success:function(message)
											{
												message = $.parseJSON(message);
												$("#LogIn").html("Welcome<br/>Single Events");
												for(SingleEvent in message.SingleEvents)
													{
														
														GetAndSetEventName(message.SingleEvents[SingleEvent]);
													}
												$("#LogIn").append("<br/>Team Events").appendTo(document.body);
												
												for(TeamEvent in message.TeamEvents)
													{
														GetAndSetEventName(message.TeamEvents[TeamEvent]);
													}												
												//Function to process returned events list
											}
				}
			   );
	}

function GetMyTeam(teamid,eventid)
	{
				$.ajax(
			   	{
					type:"GET",
					url:"frontend/inferno.php?action=team",
					data:{TeamID:teamid,EventID:eventid},
					cache:false,
					success:function(message)
											{
												alert(message);
												//process this jSON return 
											}
				}
			   );
	}
	
function CreateTeam(eventid)
	{
				$.ajax(
			   	{
					type:"GET",
					url:"frontend/inferno.php?action=create",
					data:{EventID:eventid},
					cache:false,
					success:function(message)
											{
												alert(message);
												//process this jSON return 
											}
				}
			   );
	}

function GetMyEventsForTabs()
	{
				$.ajax(
			   	{
					url:"frontend/inferno.php?action=events",
					cache:false,
					success:function(message)
											{
												alert(message);
												//Function to process returned events list
											}
				}
			   );
	}
function GetDetails()
	{
		$.ajax(
			   	{
					url:"frontend/inferno.php?action=detail",
					cache:false,
					success:function(message)
											{
												alert(message);
												//Function to process returned events list
											}
				}
			   );
	}
	
function GetAndSetEventName(SingleEvent)
	{
		$.ajax(
			   	{
					url:"frontend/info.php",
					data:{EventID:SingleEvent},
					cache:false,
					success:function(message)
											{
												$("#LogIn").append("<p>"+message+"</p>").appendTo(document.body);
												//Function to process returned events list
											}
				}
			   );
	}