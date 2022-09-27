// Validation errors messages for Parsley
// Load this after Parsley

Parsley.addMessages('en', {
  type: {
    email:        "Please enter the correct email address",
    integer:      "Please enter the number",
  },
  required:       "*This field is required",
  minLength:      "*This field must be at least %s characters."
});

Parsley.setLocale('en');
