<!DOCTYPE html>
<html lang="en">
<?php include 'header.php'; ?>
<link rel="stylesheet" href="css/cars.css" />

<main>
    <section class="car-details">
        <div class="slideshow-container">
            <div class="mySlides fade">
                <div class="numbertext">1 / 5</div>
                <img src="assets/car26.jpg" style="width:100%">
                <div style="text-align:center">
                    <span class="dot" onclick="currentSlide(1)"></span>
                    <span class="dot" onclick="currentSlide(2)"></span>
                    <span class="dot" onclick="currentSlide(3)"></span>
                    <span class="dot" onclick="currentSlide(4)"></span>
                    <span class="dot" onclick="currentSlide(5)"></span>
                </div>
                <div class="myDiv" style="color: rgb(0, 0, 0);" >Efficient city driving with ample space</div><br>
                <h1>Tata Punch EV</h1>
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
                <img src="assets/car27.jpg" style="width:100%">
                <div style="text-align:center">
                    <span class="dot" onclick="currentSlide(1)"></span>
                    <span class="dot" onclick="currentSlide(2)"></span>
                    <span class="dot" onclick="currentSlide(3)"></span>
                    <span class="dot" onclick="currentSlide(4)"></span>
                    <span class="dot" onclick="currentSlide(5)"></span>
                </div>
                <div class="myDiv" style="color: rgb(0, 0, 0);">Balanced performance and comfort for families</div><br>
                <h1>MG Comet EV</h1>
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
                <img src="assets/car28.jpg" style="width:100%">
                <div style="text-align:center">
                    <span class="dot" onclick="currentSlide(1)"></span>
                    <span class="dot" onclick="currentSlide(2)"></span>
                    <span class="dot" onclick="currentSlide(3)"></span>
                    <span class="dot" onclick="currentSlide(4)"></span>
                    <span class="dot" onclick="currentSlide(5)"></span>
                </div>
                <div class="myDiv" style="color: rgb(0, 0, 0);">Spacious elegance with luxurious features</div><br>
                <h1>Mahindra XUV400</h1>
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
                <img src="assets/car29.jpg" style="width:100%">
                <div style="text-align:center">
                    <span class="dot" onclick="currentSlide(1)"></span>
                    <span class="dot" onclick="currentSlide(2)"></span>
                    <span class="dot" onclick="currentSlide(3)"></span>
                    <span class="dot" onclick="currentSlide(4)"></span>
                    <span class="dot" onclick="currentSlide(5)"></span>
                </div>
                <div class="myDiv" style="color: rgb(0, 0, 0);">Exquisite craftsmanship and refined driving experience</div><br>
                <h1>Tata Nexon EV</h1>
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
                <img src="assets/car30.jpg" style="width:100%">
                <div style="text-align:center">
                    <span class="dot" onclick="currentSlide(1)"></span>
                    <span class="dot" onclick="currentSlide(2)"></span>
                    <span class="dot" onclick="currentSlide(3)"></span>
                    <span class="dot" onclick="currentSlide(4)"></span>
                    <span class="dot" onclick="currentSlide(5)"></span>
                </div>
                <div class="myDiv" style="color: rgb(0, 0, 0);">Dynamic performance fused with sleek design</div><br>
                <h1>Tata Tiago EV</h1>
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
</main>

<?php include 'footer.php'; ?>
<script src="js/slide.js"></script>
<script src="js/script.js"></script>
</body>
</html>