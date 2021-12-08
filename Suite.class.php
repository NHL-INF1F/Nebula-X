<?php


class Suite {

    private string $name;
    private string $description;
    private int $id;
    private $size;

    public function __construct($row) {
        $this->id = $row['ID'];
        $this->size = $row['suite_size'];
        $this->name = $row['name'];
        $this->description = $row['description'];
        /*$this->description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam justo eros,
            fermentum ac condimentum sit amet, dictum non dui. Nulla pellentesque nunc id
            ante porttitor commodo. Donec velit neque, volutpat eu pretium sed, consectetur quis magna.
            Nunc vestibulum imperdiet ligula. Phasellus mi felis, ullamcorper vitae nulla vulputate,
            viverra dignissim magna. Curabitur auctor hendrerit tristique. Duis interdum sapien nunc,
            ac egestas lorem dictum quis. Etiam tristique quam nec tortor fermentum cursus.";*/
    }

    /**
     * Geeft het ID van de suite.
     *
     * @return integer
     */
    public function getId() : int {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSize() {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

}