<?php


class DLS_Utility_Helper_Terms
{
    public function getRandomTermFromList($array_of_subterms, $subterms_per_term, $term_delimeter = ' ')
    {
        $number_of_terms = count($array_of_subterms);
        $subterm_array = array();

        for($t = 0; $t < $subterms_per_term; $t++)
        {
            $subterm_index = rand(0, ($number_of_terms - 1));
            // Should always be set, but check just in case
            $subterm = isset($array_of_subterms[$subterm_index]) ? $array_of_subterms[$subterm_index] : reset($array_of_subterms);
            $subterm_array[] = $subterm;
        }

        $subterm_array = array_unique($subterm_array);

        $generated_term = implode($term_delimeter, $subterm_array);
        return $generated_term;
    }
}
