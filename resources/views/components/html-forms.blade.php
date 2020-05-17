<form {!! $attributes->merge($form->attributes) !!}>
  <div style="display: none;">
    <input type="hidden" name="_hf_form_id" value="{{ $form->ID }}" />
    <input type="text" name="_hf_h{{ $form->ID }}" value="" />
    {!! $hiddenFields !!}
  </div>

  {!! $slot !!}
</form>
