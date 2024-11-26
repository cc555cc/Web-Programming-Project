document.addEventListener('DOMContentLoaded',function(){
	eventItemDefaultLoad();
	let search = document.querySelector('#search-button');
	search.addEventListener('click', function(){//add event listner to search button//
		let eventItems = Array.from(document.getElementsByClassName('event-item'));
		for(let e of eventItems){
			e.remove();//remove existing abstract event in the page//
		}
		searchWithName(document.getElementById('search-bar').value);//run searchWithName() based on user's input//
	});

	let tags = document.querySelectorAll('#tag');
	for(let tag of tags){
		tag.addEventListener('click', function(){//add event listener to all tag buttons//
			searchWithTag(this.textContent);//run searchWithTag based on the tag that user clicks on//
		});
	}
});


function searchWithName(name){
	if(document.getElementById('search-bar').value !== ""){//make sure search bar if not empty//
		for(let i = 0; i < numEvent; i++){//loop through the event item list//
			if(eventItemArray[i].EventName.toLowerCase() == name.toLowerCase()) {//compare in lower case//
				createEventItem(i);//create abstract event on the page//
			}
		}
	}else{
		eventItemDefaultLoad();
	}
}

function searchWithTag(tag){

	let eventItems = Array.from(document.getElementsByClassName('event-item'));
		for(let e of eventItems){
			e.remove();//clear the divison//
		}
	for(let i = 0; i < numEvent; i++){
		if(eventItemArray[i].Tag == tag || tag == "All") {//compare tag value in event object and in actual tag button//
			createEventItem(i);//create abstract event object//
		}
	}
	
}

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

	let eventList = document.getElementsByClassName('event-list');
	eventList[0].appendChild(eventItem);
}

//used when "ALL" tag is clicked or when the page is first loaded//
function eventItemDefaultLoad(){
	for(let i = 0; i < numEvent; i++){
        createEventItem(i);
    }
}