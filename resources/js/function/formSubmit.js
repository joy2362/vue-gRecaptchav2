export const submit = async (_this) => {
    _this.form.submit++;
    if(_this.form.submit > 2){
        _this.form.recaptcha = grecaptcha.getResponse(_this.recaptchaWidget);
    }
    const res = await _this.$post(_this.submitUrl, _this.form);
    if (res.data?.success) {
        if(_this.form.submit > 2){
            grecaptcha.reset(_this.recaptchaWidget);
        }
        _this.errors = {};
        _this.form.email = ''
        _this.form.password = ''
        _this.form.recaptcha = null
        _this.$success(res.data.message);
    }
    if (res.errors?.error) {
        _this.$error(res.errors?.error);
    }
    if (res.errors?.errors) {
        _this.errors = res.errors?.errors;
    }
}