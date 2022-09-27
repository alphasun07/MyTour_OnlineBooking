@php
    use App\Models\Article;
@endphp
<footer id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row d-flex flex-wrapfooter_center">
                <div class="col footer-links text-white">
                    <h4>SUPPORT</h4>
                    <ul>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">Forum</a></li>
                        <li><a href="{{ route('home.post.contact') }}">Contact Us</a></li>
                        <li><a href="{{ route('home.article.detail', ['slug' => (new Article)->getSlugById(Article::SITE_MAP)]) }}">Site map</a></li>
                        <li><a href="{{ route('home.article.detail', ['slug' => (new Article)->getSlugById(Article::TERMS_AND_CONDITIONS)]) }}">Terms and Conditions</a></li>
                    </ul>
                </div>
                <div class="col footer-links text-white">
                    <h4>DOCUMENTATION</h4>
                    <ul>
                        <li><a href="#">EShop Docs</a></li>
                    </ul>
                </div>
                <div class="col footer-links text-white">
                    <h4>INFORMATION</h4>
                    <ul>
                        <li><a href="#">Login / Register</a></li>
                        <li><a href="#">My Downloads</a></li>
                        <li><a href="#">Support Tickets</a></li>
                        <li><a href="#">Site map</a></li>
                        <li><a href="{{ route('home.post.contact') }}">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col footer-links text-white">
                    <h4>NEWSLETTER</h4>
                    <div>Don’t miss any updates of our new extensions and all the astonishing offers we bring for you. We never spam</div>
                </div>
            </div>
            <div class="py-4 d-flex">
                <div class="copyright w-75">
                    Copyright © 2022 Laravel by PCMdonation. All Rights Reserved.
                </div>
                <div class="w-25">
                    <h4 class="text-center pb-0">Connect Us</h4>
                    <div class="social-links div3 d-flex justify-content-center">
                        <a target="_blank" href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                        <a target="_blank" href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center active"><i class="bi bi-arrow-up-short"></i></a>
