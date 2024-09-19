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
                <form class="hero-form mt-lg-5 mt-3 input-group w-lg-50 mx-auto" action="search.php">
                    <select name="brand" class="year bg-form-color text-light form-control">
                        <?php
                        $statement = $pdo->prepare("SELECT * FROM tbl_top_category;");
                        $statement->execute();
                        $result = $statement->fetchAll();
                        foreach ($result as $row) { ?>
                            <option value="<?php echo $row['tcat_id']; ?>"><?php echo $row['tcat_name']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <select name="year" class="brand bg-form-color text-light form-control">
                        <?php
                        $current_year = date('Y');
                        $statement = $pdo->prepare("SELECT * FROM tbl_year
                        ORDER BY id desc;");
                        $statement->execute();
                        $result = $statement->fetchAll();
                        foreach ($result as $row) { ?>
                            <option value="<?php echo $row['name']; ?>" <?php
                               if ($row['name'] == $current_year) {
                                   echo ' selected="selected"';
                               }
                               ?>><?php echo $row['name']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <input type="text" name="p_name" placeholder="Car Name"
                        class="name bg-form-color text-light form-control" />
                    <button class="btn btn-highlight btn-find form-control">
                        <i class="fa-solid fa-magnifying-glass find-icon"></i>
                    </button>
                </form>
                <img src="assets/img/hero-img-2.png" alt="car side image" class="mt-lg-5 mt-2 hero-img" />
            </div>
        </div>
    </div>
</section>