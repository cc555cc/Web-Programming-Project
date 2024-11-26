//variable to store the value from events from the database//
let eventId, userId, eventName, month, day, year, startHour, startMin, endHour, endMin, eventLocation, description, price, image, popularity;
let guestList = new Array();
let userName; 

document.addEventListener("DOMContentLoaded", function() {
    eventDetailSetUp();
    fillGuestList();
    var likeButton = document.getElementById('like-value-1');
    likeButton.value = popularity;
    likeButton = document.getElementById('like-value-2');
    likeButton.value = eventId;
    likeButton.addEventListener('click',function(){
    	document.getElementById('about-user').style.backgroundColor = "#FF6347";
    });
});

//this function populate the page with event information to corresponding division//
function eventDetailSetUp(){
	document.getElementById('event-info-name').textContent = eventName;
	document.getElementById('event-month').textContent = month;
	document.getElementById('event-day').textContent = day;
	document.getElementById('event-year').textContent = year;
	document.getElementById('start-hour').textContent = (startHour < 10)? ("0" + startHour) : startHour;
	document.getElementById('start-min').textContent = (startMin < 10)? ("0" + startMin) : startMin;
	document.getElementById('end-hour').textContent = (endHour < 10)? ("0" + endHour) : endHour;
	document.getElementById('end-min').textContent = (endMin < 10)? ("0" + endMin) : endMin;
	document.getElementById('event-location').textContent = eventLocation;
	document.getElementById('event-info-description').textContent = description;
	document.getElementById('event-main-image').src = "uploads\\ "+image;
	document.getElementById('price').textContent = "Price: $"+price;
	document.getElementById('popularity-display').textContent = popularity;

	document.getElementById('username').textContent = userName;

}

//this function populate the guest list with guest's username//
function fillGuestList(){
	if(guestList.length > 0){//loop through guest list//
		document.getElementById('event-guest-list-filler').textContent = "";
		let division = document.getElementById('event-guest-list');
		for(let i = 0 ; i < guestList.length; i++){
			let p  = document.createElement('p');
			p.textContent = guestList[i];
			division.appendChild(p);//populate guest list with new paragraph//
		}
	}
}