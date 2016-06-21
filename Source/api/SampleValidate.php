<?php
.
..
...

$data = $request->request->all();

// 入力チェック
$errors = $this->customerValidation($app, $data);


/**
 * @param Application $app
 * @param array $data
 * @return array
 */
private function customerValidation(Application $app, array $data)
{
    // 入力チェック
    $errors = array();

    $errors[] = $app['validator']->validateValue($data['customer_name01'], array(
        new Assert\NotBlank(),
        new Assert\Length(array('max' => $app['config']['name_len'],)),
        new Assert\Regex(array('pattern' => '/^[^\s ]+$/u', 'message' => 'form.type.name.firstname.nothasspace'))
    ));

    $errors[] = $app['validator']->validateValue($data['customer_name02'], array(
        new Assert\NotBlank(),
        new Assert\Length(array('max' => $app['config']['name_len'], )),
        new Assert\Regex(array('pattern' => '/^[^\s ]+$/u', 'message' => 'form.type.name.firstname.nothasspace'))
    ));

    return $errors;
}

.
..
...
