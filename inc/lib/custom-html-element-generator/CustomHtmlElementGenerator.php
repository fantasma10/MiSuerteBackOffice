<?php
class CustomHtmlElementGenerator
{
    public function openingTag ($element, $attributes) {
        $html = "<$element ";

        foreach ($attributes as $attribute => $value) {
            if ($attribute === 'style') {
                $html .= 'style="';
                foreach ($value as $property => $propertyValue) {
                    $html .= "$property: $propertyValue;";
                }
                $html .= '"';
            } else {
                $html .= "$attribute=\"$value\"";
            }
        }

        return $html . '>';
    }

    public function closingTag ($element) {
        return "</$element>";
    }

    public function generateElement ($element, $attributes, $content) {
        $html = $this->openingTag($element, $attributes);
        if (is_callable($content)) {
            $html .= $content();
        } else {
            $html .= $content;
        }
        return $html . $this->closingTag($element);
    }

    public function table ($attributes, $content) {
        return $this->generateElement('tr', $attributes, $content);
    }

    public function th ($attributes, $content) {
        return $this->generateElement('th', $attributes, $content);
    }

    public function tr ($attributes, $content) {
        return $this->generateElement('tr', $attributes, $content);
    }

    public function td ($attributes, $content) {
        return $this->generateElement('td', $attributes, $content);
    }

    public function meta ($attributes, $content) {
        return $this->generateElement('meta', $attributes, $content);
    }
}


?>
