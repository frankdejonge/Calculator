# So, there's this thing called a calculator.

On a lonely Saturday evening, my girlfriend was out of town, I was in need of some serious nerding. A challenge came to light when one of the people in my IRC channel was given a coding challenge. I had just went to one of the @AmsterdamPHP (follow them, they're awesome) meet-ups here in Amsterdam (duh…). I was up for the challenge.

The original challenge was to write a basic calculator without using PHP. All normal math rules applied, like precedence of mathematical operators. The time-limit was one hour, so the objective probably was to see what kind of quality the code would have in a limited timeframe.

This was nice and all, I build a basic functional calculator within the hour but I was craving for more. The knowledge I just acquired about the SOLID principles were fresh in my mind and this was a great opportunity to see those words of wisdom in actions.

## The result

I can honestly say, that I didn't expect myself to go this far into it. It was my first go at a lexer-ish project but the scope was pretty limited. During the process I've changed strategies a couple of time (3 or 4, maybe), but the end result was more than I expected.

The calculator can now:

#### Do basic math
* Additions
* Subtractions
* Multiplications
* Divisions
* Powers

#### While taking into account
* Precedence or operators (3 levels)
* Nested expressions: `(1 + 2) * 3)`
* …FUNCTIONS

I added mathematical functions into the mix. This was an exercise to see wether my code was open enough to extend upon. Also, another guy in the IRC challenged me to try it, so yeah.

## Check it out for yourself.

You can run the code from the terminal, which gives you an interactive window to send mathematical queries to.

```
$ php calculator_assignment.php
```

… and off you go.


