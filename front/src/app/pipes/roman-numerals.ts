import { Pipe, PipeTransform } from '@angular/core';
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
        let result = '';
        let decimal = [1000, 900, 500, 400, 100, 90, 50, 40, 10, 9, 5, 4, 1];
        let roman = ["M", "CM", "D", "CD", "C", "XC", "L", "XL", "X", "IX", "V", "IV", "I"];
        for (let i = 0; i <= decimal.length; i++) {
            while (value % decimal[i] < value) {
                result += roman[i];
                value -= decimal[i];
            }
        }
        return result;
    }
}