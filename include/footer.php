<footer>
    <div class="container">
        <div class="footer-top">
            <div class="row">
                <div class="col-md-3">
                    <div class="position-footer-left">
                        <h5 class="toggled title">
                            contact
                        </h5>
                        <ul class="list-unstyled">
                            <?php
                            $statement = $pdo->prepare("SELECT * FROM tbl_contact WHERE id=1");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $heading = $row['heading'];
                                $address = $row['address'];
                                $phone_no_1 = $row['phone_no_1'];
                                $phone_no_2 = $row['phone_no_2'];
                                $email = $row['email'];
                                $map_links = $row['map_links'];
                            }
                            ?>
                            <li>
                                <div class="site">
                                    <div class="contact_title"><i class="fa-solid fa-location-dot"></i></div>
                                    <div class="contact_site"><?= $address; ?></div>
                                </div>
                            </li>
                            <li>
                                <div class="phone">
                                    <div class="contact_title"><i class="fa fa-phone"></i></div>
                                    <div class="contact_site"><a href="tel:+91<?= $phone_no_1; ?>" class="contact_site">+91 - <?= $phone_no_1; ?></a></div>
                                </div>
                            </li>
                            <li>
                                <div class="fax">
                                    <div class="contact_title"><i class="fa fa-fax"></i></div>
                                    <div class="contact_site"><a href="tel:+91<?= $phone_no_2; ?>" class="contact_site">+91 - <?= $phone_no_2; ?></a></div>
                                </div>
                            </li>
                            <li>
                                <div class="email">
                                    <div class="contact_title"><i class="fa fa-envelope"></i></div>
                                    <div class="contact_site"><a href="mailto:<?= $email; ?>"
                                            class="contact_site"><?= $email; ?></a></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3">
                    <h5 class="toggled">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About Us</a></li> 
                        <li><a href="blog.php">Blog</a></li>
                         <li><a href="faq.php">Faq </a></li> 
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5 class="toggled">Policies</h5>
                    <ul class="list-unstyled">
                        <li><a href="terms-conditions.php">Terms & Conditions</a></li>
                        <li><a href="shipping-delivery.php">Shipping & Delivery</a></li>
                        <li><a href="payment-info.php">Payments</a></li>
                        <li><a href="privacy-policy.php">Privacy Policy</a></li>
                        <li><a href="return-policy.php">Return policy</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5 class="toggled">Info & Help</h5>
                    <ul class="list-unstyled">
                        <li><a href="about.php">Introduction</a></li>
                        <li><a href="index.php#faq">FAQs</a></li>
                        <li><a href="privacy-policy.php">Privacy Policy</a></li>
                        <li><a href="return-policy.php">Return policy</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <div class="position-footer-right">
                        <div class="follow-link">
                            <h4>find us on</h4>
                            <div class="social-media">
                                <a href=" https://www.facebook.com/JaipurWindow" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                                <a href="https://www.instagram.com/JaipurWindow" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                                <a href="https://x.com/jaipurwindow" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
                                <!-- <a href="#" target="_blank"><i class="fa-brands fa-pinterest-p"></i></a> -->
                            </div>
                        </div>
                        <div class="payment-link">
                            <h4>payment</h4>
                            <div class="payment-method">
                                <a href="#"><i class="fa-brands fa-cc-visa"></i></a>
                                <a href="#"><i class="fa-brands fa-cc-mastercard"></i></a>
                                <a href="#"><i class="fa-brands fa-cc-paypal"></i></a>
                                <a href="#"><i class="fa-brands fa-cc-discover"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p class="copyright">© <?= date('Y'); ?> Jaipur Window | All Rights Reserved | <a href="https://firstpointwebdesign.com/" target="blank">E-commerce Website Designed </a> - By - <a href="https://firstpointwebdesign.com/" target="blank"> First Point Web Design</a></p>
    </div>
    <a class="scrollToTop back-to-top" title="Top"></a>
</footer>