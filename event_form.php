<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventSphere - Create an Event</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .form-container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }
        .form-container h1 {
            text-align: center;
            color:#FF6347;
        }
        label {
            font-weight: bold;
        }
        input, textarea, select, button{
            display: inline;
            width: 97%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #FF6347;
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }

        #month, #day, #year, #start_hour, #start_minute, #end_hour, #end_minute{
            display: inline;
            width: 13vh;
            height: 6vh;
        }

        #start_hour,#start_minute, #end_hour, #end_minute{
            height: 1vh;
            width: 7vh;
        }
        #tag{
            display:block;
           width:30vh;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Create an Event</h1>
        <form action="process_event.php" method="POST" enctype="multipart/form-data">
            <!-- Event Name -->
            <label for="event_name">Event Name:</label>
            <input type="text" id="event_name" name="event_name" required>

            <!-- Date -->
            <label for="month">Date: </label>
            <select id="month" name="month" required>
                <?php foreach (range(1, 12) as $month): ?>
                    <option value="<?= $month ?>"><?= date("F", mktime(0, 0, 0, $month, 10)) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="day"> , </label>
            <select id="day" name="day" required>
                <?php foreach (range(1, 31) as $day): ?>
                    <option value="<?= $day ?>"><?= $day ?></option>
                <?php endforeach; ?>
            </select>

            <label for="year"> , </label>
            <select id="year" name="year" required>
                <?php foreach (range(date("Y"), date("Y") + 5) as $year): ?>
                    <option value="<?= $year ?>"><?= $year ?></option>
                <?php endforeach; ?>
            </select>
        </br>

            <!-- Start Time -->
            <label>Time:</label></br>
            <input type="number" id="start_hour" name="start_hour" min="0" max="23" placeholder="Hour" required> <strong> : </strong>
            <input type="number" id="start_minute" name="start_minute" min="0" max="59" placeholder="Min" required>

            <!-- End Time -->
            <label> - </label>
            <input type="number" id="end_hour" name="end_hour" min="0" max="23" placeholder="Hour" required><strong> : </strong>
            <input type="number" id="end_minute" name="end_minute" min="0" max="59" placeholder="Min" required>

        </br>

            <!-- Description -->
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="5" required></textarea>

            <!-- Location -->
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>

            <!-- Price -->
            <label for="price">Price (in CAD):</label>
            <input type="number" id="price" name="price" min="0" step="0.01"  required>

            <!--Image-->
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/jpeg, image/png">

            <!-- Tag -->
            <label for="tag">Tag:</label>
            <select id="tag" name="tag">
                <option value="none">none</option>
                <option value="Festivals and Concerts">Festivals and Concerts</option>
                <option value="Seminars">Seminars</option>
                <option value="Sports">Sports</option>
                <option value="Cultural Events and Parades">Cultural Events and Parades</option>
                <option value="Performing & Visual Arts events">Performing & Visual Arts events</option>
                <option value="Nightlife">Nightlife</option>
                <option value="Food & Drink">Food & Drink</option>
                <option value="Charity & Causes">Charity & Causes</option>
            </select>

            <!-- Submit -->
            <button type="submit">Create Event</button>


        </form>
    </div>
</body>
</html>
