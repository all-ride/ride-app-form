The Form library makes it easy to create a form in your Controller.

## Form
A form is always created in the same way. It starts by simply adding the following code in your controller:

    $form = $this->creatFormBuilder();

To view the form in your template you will need to add the following code to your content block in that template:

    {include file="base/form.prototype"}

    <form id="{$form->getId()}" class="form-horizontal" method="post" action="{$app.url.request}" role="form">
        {call formRows form=$form}

        <input type="submit" class="btn" value="{translate key="button.submit"}" />
    </form>

The include file makes you run the {call formRows form=$form}.

With action="{$app.url.request}" you'll send the request back to the action where the form is called.

To add the form to your template view, You'll need to add it.

    $this->setTemplateView('folder/view.form', array(
        'form' => $form->getView();
    );

### Row
A form consists of Rows, Here you can define what you want to be viewed.
#### Row Types
Row types are a way of telling your form what kind of input type you are expecting from the row

The following input types can be used while creating your row:

* collection
* component
* date
* email
* file
* hidden
* image
* label
* number
* option
* password
* select
* string
* text
* website
* wysiwyg

### Row Construction (simple)
The example below is a simple way of creating an input field to ask for a name.

Where 'name' is the name for your row. This will show in html as 'form-name'

    $form->addRow('name', 'string', array();


### Row construction (advanced)
 There can be added a lot more parameters to a row. Like filters and validators or a label.

      $form->addRow('email', 'email', array(
            'label' => $translator->translate('websitename.label.email'),
            'filters' => array(
                'trim' => array(),
            ),
            'validators' => array(
                'required' => array(),
            ),
        ));

#### Label
A label defines your row on a webpage.
You can directly give the value to a label or you can work with a translator if you are creating a multilangual website

    'label' => 'city'
    'label' => $translator->translate('websitename.label.city')

When using a translator you'll need to add the following line at the start of your Controller Action:

    $translator = $this->getTranslator();

#### Filters
Filters are a way to filter your input before it gets processed by the form
Usable filters are:

* lowercase
* replace
* trim
* uppercase

They are easily implemented in your row by adding the following:

    'filters' => array(
        'trim' => array(),
        'uppercase' => 'array(),
        'replace' => array(
            'search' => 'search_word',
            'replace' => 'replace_word'
    )

These filters are explained in the Validation API under filter  [ride\library\validation\filter](/api/namespace/ride/library/Validation/filter)

#### Parameters
The following parameters can be given to your row

Attributes: these will be added to your input field. e.g. value, placeholder,...

    'attributes' => array(
        placeholder => 'Put your name here'
    )

Description: This adds a value underneath your form row with an explanation

    'description' => 'Add a word with more than 6 characters'

Disabled: Disables the row

    'disabled' => true

Readonly: This will make the row read only

    'readonly' => true

#### Validators
With the validator parameter, you can validate a row before it will be processed.
Usable validators are:

* class
* dns
* email
* fileextension
* minmax
* nested
* numeric
* regex
* required
* size
* url
* website

These are easily implemented in your row by adding the following:

    'validators' => array(
        'required' => array(),
        'numeric' => array(),
        'size' => array(
            'minimum' => 4,
            'maximum' => 8
        )
    )

These validators are explained in the Validation API under validator [ride\library\validation\validator](/api/namespace/ride/library/validation/validator)

## Form Handling
After The submit button is pressed This piece of code will handle your form.

In your code this is handled with:

    if($form->isSubmitted()) {
        try {
            $form->validate();
            $records = $form->getData()

            ... here you can process your data
            you can access your date with $records['city'] where 'city' is the rowname you added

        } catch (ValidationException $exception) {
            $this->response->setStatusCode(Response::STATUS_CODE_UNPROCESSABLE_ENTITY);
            $this->addError('error.validation');
        }
    }


