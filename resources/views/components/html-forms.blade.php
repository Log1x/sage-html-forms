<form {!! $attributes->merge($form->attributes) !!}>
  <div style="display: none;">
    {!! wp_nonce_field('html_forms_submit', '_wpnonce', true, false) !!}
    <input type="hidden" name="_hf_form_id" value="{{ $form->ID }}" />
    <input type="text" name="_hf_h{{ $form->ID }}" value="" />
    {!! $hidden !!}
  </div>

  <div class="hf-fields-wrap">
    {!! $slot !!}
  </div>
</form>
