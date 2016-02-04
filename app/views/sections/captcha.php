<?php if ($gcaptchaEnable == true): ?>
    <input id="foo-captcha" name="captcha" type="hidden" value="1" />
    <?php echo $this->formFieldError('captcha'); ?>
    <div class="g-recaptcha" style="margin-bottom:10px;" data-sitekey="<?php echo $gcaptchaSitekey; ?>"></div>
<?php endif; ?>
