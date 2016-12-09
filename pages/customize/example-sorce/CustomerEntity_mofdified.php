<?php
.
..
...
/**
 * @var integer
 */
private $del_flg;

/**
 * @var string
 */
private $department;

.
..
...

/**
 * Get zipcode
 *
 * @return string
 */
public function getZipcode()
{
    return $this->zipcode;
}

/**
 * Set department
 *
 * @param $department
 * @return $this
 */
public function setDepartment($department)
{
    $this->department = $department;

    return $this;
}

/**
 * Get department
 *
 * @return string
 */
public function getDepartment()
{
    return $this->department;
}
