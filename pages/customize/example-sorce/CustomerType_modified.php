<?php
.
..
...
->add('department', 'text', array(
    'required' => false,,
    'label' => '部署名',
    'constraints' => array(
        new Assert\Length(array(
            'max' => $config['stext_len'],
        ))
    ),
))
.
..
...
