<?php
namespace MathPHP\Probability\Distribution\Discrete;

use MathPHP\Probability\Combinatorics;
use MathPHP\Exception;

/**
 * Multinomial distribution (multivariate)
 *
 * https://en.wikipedia.org/wiki/Multinomial_distribution
 */
class Multinomial extends Discrete
{
    /**
     * Probability mass function
     *
     *          n!
     * pmf = ------- p₁ˣ¹⋯pkˣᵏ
     *       x₁!⋯xk!
     *
     * n = number of trials (sum of the frequencies) = x₁ + x₂ + ⋯ xk
     *
     * @param  array $frequencies
     * @param  array $probabilities
     *
     * @return float
     *
     * @throws Exception\BadDataException if the number of requencies does not match the number of probabilites
     *                                    if the probabilityes do not add up to 1
     */
    public static function pmf(array $frequencies, array $probabilities): float
    {
        // Must have a probability for each frequency
        if (count($frequencies) !== count($probabilities)) {
            throw new Exception\BadDataException('Number of frequencies does not match number of probabilities.');
        }

        // Probabilities must add up to 1
        if (round(array_sum($probabilities), 1) != 1) {
            throw new Exception\BadDataException('Probabilities do not add up to 1.');
        }

        $n   = array_sum($frequencies);
        $n！ = Combinatorics::factorial($n);

        $x₁！⋯xk！ = array_product(array_map(
            'MathPHP\Probability\Combinatorics::factorial',
            $frequencies
        ));

        $p₁ˣ¹⋯pkˣᵏ = array_product(array_map(
            function ($x, $p) {
                return $p**$x;
            },
            $frequencies,
            $probabilities
        ));

        return ($n！ / $x₁！⋯xk！) * $p₁ˣ¹⋯pkˣᵏ;
    }
}
