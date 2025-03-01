<style>
    .list-unstyled li a {
        color: white;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .list-unstyled li a:hover {
        color: rgb(163, 211, 255);
    }

    input.btn.i {
        border: 2px solid white;
        width: 75%;
        padding: 10px;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
    }

    button.btn.o {
        border: 2px solid white;
        padding: 10px;
        font-weight: bold;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        background-color: white;
        color: #007bff; /* Button text color */
        cursor: pointer;
    }

    ::placeholder {
        color: white;
        opacity: 0.8;
    }

    footer {
        left: 0;
        bottom: 0;
        width: 100%;
    }

    .footer-container {
        padding: 10px;
        background-color: #007bff; /* Footer background color */
        color: white;
    }


    .footer-container p,
    .footer-container ul li {
        color: white;
    }

    .footer-social img {
        margin-right: 10px;
        transition: transform 0.3s ease;
    }

    .footer-social img:hover {
        transform: scale(1.1);
    }

    .footer-newsletter form {
        display: flex;
        flex-wrap: nowrap;
    }

    .footer-newsletter input,
    .footer-newsletter button {
        transition: all 0.3s ease;
    }

    .footer-newsletter button:hover {
        background-color: #0056b3;
        color: white;
    }

    .footer-copyright {
        padding: 10px 0;
        background-color: #ffffff;
        color: #007bff; /* Footer copyright text color */
    }

    .footer-copyright a {
        color: #007bff; /* Link color */
        text-decoration: underline;
    }

    .footer-copyright a:hover {
        color: rgb(163, 211, 255);
    }

    @media (max-width: 767px) {
        .footer-container .row {
            flex-direction: column;
            text-align: center;
        }

        .footer-container .col-md-2,
        .footer-container .col-md-2.5,
        .footer-container .col-md-1.5 {
            margin-bottom: 20px;
        }
        
        .footer-newsletter form {
            flex-direction: column;
            align-items: center;
        }

        .footer-newsletter input {
            width: 100%;
            margin-bottom: 10px;
        }

        .footer-newsletter button {
            width: 100%;
        }
    }
</style>

<footer>
    <div class="footer-container">
        <div class="container-fluid text-center text-md-left">
            <div class="row text-white">
                <div class="col-md-2 mx-auto">
                    <p>About Us</p>
                    <p>My Furniture offers high-quality furniture and household appliances for every home.</p>
                </div>
                <div class="col-md-2.5 mx-auto">
                    <p>Customer Service</p>
                    <ul class="list-unstyled">
                        <li><a href="#!">Contact Us</a></li>
                        <li><a href="#!">Ordering & Payment</a></li>
                        <li><a href="#!">Delivery</a></li>
                        <li><a href="#!">Return</a></li>
                        <li><a href="#!">Related Questions</a></li>
                    </ul>
                </div>
                <div class="col-md-1.5 mx-auto">
                    <p>Information</p>
                    <ul class="list-unstyled">
                        <li><a href="#!">Privacy Policy</a></li>
                        <li><a href="#!">Terms and Conditions</a></li>
                        <li><a href="#!">Press</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mx-auto footer-newsletter">
                    <p>Feedback</p>
                    <form action="#">
                        <input class="btn i" type="email" placeholder="Your Email">
                        <button class="btn o" type="submit">OK</button>
                    </form>
                </div>
                <div class="col-md-2 mx-auto">
                    <p>Contact Us</p>
                    <ul class="list-unstyled">
                        <li>+62 8167 2837 2626</li>
                        <li>myfurniture@gmail.com</li>
                        <li>Jl.Sukasaya Km 17</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright text-center">
        ©2020 Copyright: Mahiahijab
    </div>
</footer>
