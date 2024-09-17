<section id="hero" class="min-vh-100 bg-bg-color">
    <div class="container">
        <div class="row text-center">
            <div class="col mt-lg-5 mt-5">
                <h2 class="hero-title text-primary">
                    <?php echo $hero_title; ?>
                    <span class="hero-highlight">Easily</span>
                </h2>
                <p class="hero-para mt-lg-4 mt-2">
                    <?php echo $hero_paragraph; ?>
                </p>
                <form class="hero-form mt-lg-5 mt-3 input-group w-lg-50 mx-auto">
                    <select name="year" class="year bg-form-color text-light form-control">
                        <option value="car">Car</option>
                        <option value="car">Jeep</option>
                        <option value="car">3-Wheel</option>
                        <option value="car">Motor Bike</option>
                    </select>
                    <select name="brand" class="brand bg-form-color text-light form-control">
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                    </select>
                    <input type="text" placeholder="Car Name" class="name bg-form-color text-light form-control" />
                    <button class="btn btn-highlight btn-find form-control">
                        <i class="fa-solid fa-magnifying-glass find-icon"></i>
                    </button>
                </form>
                <img src="assets/img/hero-img-2.png" alt="car side image" class="mt-lg-5 mt-2 hero-img" />
            </div>
        </div>
    </div>
</section>