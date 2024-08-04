<!DOCTYPE html>
<html lang="en">
<?php include 'header.php'; ?>
<link rel="stylesheet" href="css/cars.css" />
<link rel="stylesheet" href="css/trip.css" />

<main>
    <section class="car-details">
        <div class="slideshow-container">
            <div class="mySlides fade">
                <div class="numbertext">1 / 5</div>
                <img src="assets/car31.jpg" style="width:100%">
                <div style="text-align:center">
                    <span class="dot" onclick="currentSlide(1)"></span>
                    <span class="dot" onclick="currentSlide(2)"></span>
                    <span class="dot" onclick="currentSlide(3)"></span>
                    <span class="dot" onclick="currentSlide(4)"></span>
                    <span class="dot" onclick="currentSlide(5)"></span>
                </div>
                <div class="myDiv" style="color: rgb(0, 0, 0);" >Efficient city driving with ample space</div><br>
                <h1>Etiga innova</h1>
                <p>Their lineup includes popular models such as the Nissan Altima, a mid-size sedan known for its fuel efficiency and comfortable ride; the Nissan Rogue, a compact SUV appreciated for its versatility and spacious interior; and the Nissan Frontier, a rugged pickup truck designed for both work and play.</p>
                <div class="travel-grid">
                    <div class="grid-item">
                        <label for="hours">Hours:</label>
                        <input type="number" id="hours" name="hours" min="1">
                    </div>
                    <div class="grid-item">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date">
                    </div>
                    <div class="grid-item">
                        <label for="km">Kilometers:</label>
                        <input type="number" id="km" name="km" min="0">
                    </div>
                </div>
                <p class="price">Price: ₹2000 per day</p><br>
                <button id="bookButton" onclick="bookNow()">Book Now</button>
            </div>
            <div class="mySlides fade">
                <div class="numbertext">2 / 5</div>
                <img src="assets/car32.jpg" style="width:100%">
                <div style="text-align:center">
                    <span class="dot" onclick="currentSlide(1)"></span>
                    <span class="dot" onclick="currentSlide(2)"></span>
                    <span class="dot" onclick="currentSlide(3)"></span>
                    <span class="dot" onclick="currentSlide(4)"></span>
                    <span class="dot" onclick="currentSlide(5)"></span>
                </div>
                <div class="myDiv" style="color: rgb(0, 0, 0);">Balanced performance and comfort for families</div><br>
                <h1>Force Toofan</h1>
                <p>Their lineup includes popular models such as the Nissan Altima, a mid-size sedan known for its fuel efficiency and comfortable ride; the Nissan Rogue, a compact SUV appreciated for its versatility and spacious interior; and the Nissan Frontier, a rugged pickup truck designed for both work and play.</p>
                <div class="travel-grid">
                    <div class="grid-item">
                        <label for="hours">Hours:</label>
                        <input type="number" id="hours" name="hours" min="1">
                    </div>
                    <div class="grid-item">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date">
                    </div>
                    <div class="grid-item">
                        <label for="km">Kilometers:</label>
                        <input type="number" id="km" name="km" min="0">
                    </div>
                </div>
                <p class="price">Price: ₹2000 per day</p><br>
                <button id="bookButton" onclick="bookNow()">Book Now</button>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">3 / 5</div>
                <img src="assets/car33.jpg" style="width:100%">
                <div style="text-align:center">
                    <span class="dot" onclick="currentSlide(1)"></span>
                    <span class="dot" onclick="currentSlide(2)"></span>
                    <span class="dot" onclick="currentSlide(3)"></span>
                    <span class="dot" onclick="currentSlide(4)"></span>
                    <span class="dot" onclick="currentSlide(5)"></span>
                </div>
                <div class="myDiv" style="color: rgb(0, 0, 0);">Spacious elegance with luxurious features</div><br>
                <h1>Mahindra Sumo</h1>
                <p>Their lineup includes popular models such as the Nissan Altima, a mid-size sedan known for its fuel efficiency and comfortable ride; the Nissan Rogue, a compact SUV appreciated for its versatility and spacious interior; and the Nissan Frontier, a rugged pickup truck designed for both work and play.</p>
                <div class="travel-grid">
                    <div class="grid-item">
                        <label for="hours">Hours:</label>
                        <input type="number" id="hours" name="hours" min="1">
                    </div>
                    <div class="grid-item">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date">
                    </div>
                    <div class="grid-item">
                        <label for="km">Kilometers:</label>
                        <input type="number" id="km" name="km" min="0">
                    </div>
                </div>
                <p class="price">Price: ₹2000 per day</p><br>
                <button id="bookButton" onclick="bookNow()">Book Now</button>
            </div>
            <div class="mySlides fade">
                <div class="numbertext">4 / 5</div>
                <img src="assets/car34.jpg" style="width:100%">
                <div style="text-align:center">
                    <span class="dot" onclick="currentSlide(1)"></span>
                    <span class="dot" onclick="currentSlide(2)"></span>
                    <span class="dot" onclick="currentSlide(3)"></span>
                    <span class="dot" onclick="currentSlide(4)"></span>
                    <span class="dot" onclick="currentSlide(5)"></span>
                </div>
                <div class="myDiv" style="color: rgb(0, 0, 0);">Exquisite craftsmanship and refined driving experience</div><br>
                <h1>Suzuki EEECO</h1>
                <p>Their lineup includes popular models such as the Nissan Altima, a mid-size sedan known for its fuel efficiency and comfortable ride; the Nissan Rogue, a compact SUV appreciated for its versatility and spacious interior; and the Nissan Frontier, a rugged pickup truck designed for both work and play.</p>
                <div class="travel-grid">
                    <div class="grid-item">
                        <label for="hours">Hours:</label>
                        <input type="number" id="hours" name="hours" min="1">
                    </div>
                    <div class="grid-item">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date">
                    </div>
                    <div class="grid-item">
                        <label for="km">Kilometers:</label>
                        <input type="number" id="km" name="km" min="0">
                    </div>
                </div>
                <p class="price">Price: ₹2000 per day</p><br>
                <button id="bookButton" onclick="bookNow()">Book Now</button>
            </div>
            <div class="mySlides fade">
                <div class="numbertext">5 / 5</div>
                <img src="assets/car35.jpg" style="width:100%">
                <div style="text-align:center">
                    <span class="dot" onclick="currentSlide(1)"></span>
                    <span class="dot" onclick="currentSlide(2)"></span>
                    <span class="dot" onclick="currentSlide(3)"></span>
                    <span class="dot" onclick="currentSlide(4)"></span>
                    <span class="dot" onclick="currentSlide(5)"></span>
                </div>
                <div class="myDiv" style="color: rgb(0, 0, 0);">Dynamic performance fused with sleek design</div><br>
                <h1>Traveller</h1>
                <p>Their lineup includes popular models such as the Nissan Altima, a mid-size sedan known for its fuel efficiency and comfortable ride; the Nissan Rogue, a compact SUV appreciated for its versatility and spacious interior; and the Nissan Frontier, a rugged pickup truck designed for both work and play.</p>
                <div class="travel-grid">
                    <div class="grid-item">
                        <label for="hours">Hours:</label>
                        <input type="number" id="hours" name="hours" min="1">
                    </div>
                    <div class="grid-item">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date">
                    </div>
                    <div class="grid-item">
                        <label for="km">Kilometers:</label>
                        <input type="number" id="km" name="km" min="0">
                    </div>
                </div>
                <p class="price">Price: ₹2000 per day</p><br>
                <button id="bookButton" onclick="bookNow()">Book Now</button>
            </div>
            <a class="prev" onclick="plusSlides(-1)">❮</a>
            <a class="next" onclick="plusSlides(1)">❯</a>
        </div>
        <br>
    </section>

    <section class="trip-section">
        <div class="filters">
            <h2>Filters</h2>
            <div class="filter-group">
                <label for="popular_places" >Popular Places:</label>
                <select id="popular_places" name="popular_places" class="btn1">
                    <option value="goa">Goa</option>
                    <option value="kerala">Kerala</option>
                    <option value="rajasthan">Rajasthan</option>
                    <!-- Add more options as needed -->
                </select>
            </div>

            <div class="filter-group">
                <label for="star_rating" >Star Rating:</label>
                <select id="star_rating" name="star_rating" class="btn1">
                    <option value="1">1 star</option>
                    <option value="2">2 stars</option>
                    <option value="3">3 stars</option>
                    <option value="4">4 stars</option>
                    <option value="5">5 stars</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="price_sort">Price:</label>
                <select id="price_sort" name="price_sort" class="btn1">
                    <option value="high_low">High to Low</option>
                    <option value="low_high">Low to High</option>
                </select>
            </div>
        </div>
        <div id="bookingFormContainer"></div>
    </section>
    </div>
    </section>


    <section class="gallery section" id="gallery">

        <h1 class="heading">
            <span>g</span>
            <span>a</span>
            <span>l</span>
            <span>l</span>
            <span>e</span>
            <span>r</span>
            <span>y</span>
        </h1>

        <div class="box-container">

            <div class="box">
                <img src="assets/g-1.jpg" alt="">
                <div class="content">
                    <h3>amazing places</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, tenetur.</p>
                    <a href="#" class="btn">see more</a>
                </div>
            </div>
            <div class="box">
                <img src="assets/g-2.jpg" alt="">
                <div class="content">
                    <h3>amazing places</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, tenetur.</p>
                    <a href="#" class="btn">see more</a>
                </div>
            </div>
            <div class="box">
                <img src="assets/g-3.jpg" alt="">
                <div class="content">
                    <h3>amazing places</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, tenetur.</p>
                    <a href="#" class="btn">see more</a>
                </div>
            </div>
            <div class="box">
                <img src="assets/g-4.jpg" alt="">
                <div class="content">
                    <h3>amazing places</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, tenetur.</p>
                    <a href="#" class="btn">see more</a>
                </div>
            </div>
            <div class="box">
                <img src="assets/g-5.jpg" alt="">
                <div class="content">
                    <h3>amazing places</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, tenetur.</p>
                    <a href="#" class="btn">see more</a>
                </div>
            </div>
            <div class="box">
                <img src="assets/g-6.jpg" alt="">
                <div class="content">
                    <h3>amazing places</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, tenetur.</p>
                    <a href="#" class="btn">see more</a>
                </div>
            </div>
            <div class="box">
                <img src="assets/g-7.jpg" alt="">
                <div class="content">
                    <h3>amazing places</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, tenetur.</p>
                    <a href="#" class="btn">see more</a>
                </div>
            </div>
            <div class="box">
                <img src="assets/g-8.jpg" alt="">
                <div class="content">
                    <h3>amazing places</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, tenetur.</p>
                    <a href="#" class="btn">see more</a>
                </div>
            </div>
            <div class="box">
                <img src="assets/g-9.jpg" alt="">
                <div class="content">
                    <h3>amazing places</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, tenetur.</p>
                    <a href="#" class="btn">see more</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="js/slide.js"></script>
<script src="js/script.js"></script>
</body>
</html>