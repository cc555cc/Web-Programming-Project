var currentUserID;
//after all elements are loaded, run the 2 search function//
document.addEventListener('DOMContentLoaded',function(){
		searchWithID(currentUserID);
		searchJoinedEvent(currentUserID);
});

//this function loop through the array list with event object and compare their userID value with the userID value from the login session//
function searchWithID(id){
	let array = [];
		for(let i = 0; i < numEvent; i++){
			if(eventItemArray[i].userID == id) {
				array.push(i);
			}
		}
	if(array.length > 0){
		document.getElementsByClassName('event-list')[0].textContent = "";
		for(let i = 0; i < array.length; i++){
			createEventItem(array[i],"event-list");
		}
	}
}

//Similar to the searchWithID, this function also match userID from event Object with userID from session, except it also loop through the guestIDList from the 
function searchJoinedEvent(id){
	let array = [];
		for(let i = 0; i < numEvent; i++){//the array of event//
			let guestList = JSON.parse(eventItemArray[i].guestIDs);
			if(guestList != null){
				for(let j = 0; j < guestList.length; j++){//the array of guestIDList//
					if(guestList[j] == id){
						array.push(i);
					}
				}
			}
		}
	if(array.length > 0){
		document.getElementsByClassName('joined-event-list')[0].textContent = ""; //clear the default content//
		for(let i = 0; i < array.length; i++){
			createEventItem(array[i],"joined-event-list");//create abstract event//
		}
	}
}

//this function create abstract event on the page//
function createEventItem(i, name=""){
	let image = document.createElement('img');
	image.src = "uploads\\ " + eventItemArray[i].Image;

	let eventInfo = document.createElement('div');
	eventInfo.className = "event-info";
	let eventId = eventItemArray[i].eventID;

	let h4 = document.createElement('h4');
	let linkToDetail = document.createElement('a');
	linkToDetail.href = "eventDetail.php?eventID=" + eventId;
	linkToDetail.textContent = eventItemArray[i].EventName;
	h4.appendChild(linkToDetail);
	eventInfo.appendChild(h4);

	let month = document.createElement('span');
	month.id = "month";
	month.textContent = eventItemArray[i].Month + "-";
	eventInfo.appendChild(month);

	let day = document.createElement('span');
	day.id = "day";
	day.textContent = eventItemArray[i].Day + "-";
	eventInfo.appendChild(day);

	let year = document.createElement('span');
	year.id = "year";
	year.textContent = eventItemArray[i].Year;
	eventInfo.appendChild(year);

	let price = document.createElement('p');
	price.className = "price";
	price.textContent = "$" + eventItemArray[i].Price;
	eventInfo.appendChild(price);

	let eventItem = document.createElement('div');
	eventItem.className = "event-item";
	eventItem.appendChild(image);
	eventItem.appendChild(eventInfo);

	let eventList = document.getElementsByClassName(name);
	eventList[0].appendChild(eventItem);
}