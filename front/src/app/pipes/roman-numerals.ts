import { Pipe, PipeTransform } from '@angular/core';
export interface RomanNumeralsData {
    arabic: number;
    roman: string;
}
/*
 * Transform decimal numbers to roman numerals.
 * Usage:
 *   value | romanNumerals
 * Example:
 *   {{ 2 | romanNumerals }}
 *   formats to: II
*/
@Pipe({name: 'romanNumerals'})
export class RomanNumerals implements PipeTransform {
    transform(value: number): string {
        let data: RomanNumeralsData[] = [
            {
                arabic: 1000,
                roman: 'M',
            },
            {
                arabic: 900,
                roman: 'CM',
            },
            {
                arabic: 500,
                roman: 'D',
            },
            {
                arabic: 400,
                roman: 'CD',
            },
            {
                arabic: 100,
                roman: 'C'
            },
            {
                arabic: 90,
                roman: 'XC'
            },
            {
                arabic: 50,
                roman: 'L'
            },
            {
                arabic: 40,
                roman: 'XL'
            },
            {
                arabic: 10,
                roman: 'X'
            },
            {
                arabic: 9,
                roman: 'IX'
            },
            {
                arabic: 5,
                roman: 'V'
            },
            {
                arabic: 4,
                roman: 'IV'
            },
            {
                arabic: 1,
                roman: 'I'
            }
        ];
        let result = '';
        let remaining = value;

        data.forEach(function(v) {
           while (remaining % v.arabic < remaining) {
               result += v.roman;
               remaining -= v.arabic;
           }
        });

        return result;
    }
}