<link href="<?= base_url('css/onboarding.css?v=0.0.2') ?>" rel="stylesheet">
<script>
    const url_enter_img = '<?= base_url('img/icons8-enter-key-50.png') ?>';
</script>

<!-- Progress bar -->
<div class="progress mx-2" style="height: 5px;">
    <div class="progress-bar" role="progressbar" style="width: 0%;" id="progressBar"></div>
</div>

<!-- Navigation buttons -->
<div class="container-fluid d-flex justify-content-between align-items-center mt-2">
    <a href="#" onclick="previousQuestion()" id="btn-previous-question">&lt; Back to previous</a>
    <a href="#" onclick="nextQuestion()" id="btn-skip-question">Skip question &gt;</a>
</div>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div id="onboarding-step-container" class="bg-white p-4 shadow rounded">
    </div>
</div>

<script src="<?= base_url('js/onboarding/onboarding-questions.js') ?>"></script>
<script src="<?= base_url('js/onboarding/onboarding-logic.js') ?>"></script>