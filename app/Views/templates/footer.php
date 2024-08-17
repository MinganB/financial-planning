</main>

<footer class="bg-light text-muted py-3">
    <div class="container">

        <!-- Desktop Footer -->
        <div class="d-none d-lg-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1"><?= APP_NAME ?></h5>
                <p class="mb-0">Iconography courtesy of <a href="#" class="text-muted">Icons8</a>.</p>
            </div>
            <div class="flex-grow-1"></div> <!-- Empty middle column -->
            <div class="d-flex">
                <div class="me-4">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-muted">Home</a></li>
                        <li><a href="#" class="text-muted">About</a></li>
                        <li><a href="#" class="text-muted">Get in touch</a></li>
                    </ul>
                </div>
                <div>
                    <h6>Legal</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-muted">Privacy policy</a></li>
                        <li><a href="#" class="text-muted">Terms of service</a></li>
                        <li><a href="#" class="text-muted">POPIA compliance</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Mobile Footer -->
        <div class="d-lg-none text-center">
            <p class="mb-0">&copy; 2024 <?= APP_NAME ?>. All rights reserved.</p>
        </div>
    </div>
</footer>

<script src="<?= base_url('bootstrap5/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>