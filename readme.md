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
* Nested expressions: `((1 + 2) * 3)`
* …FUNCTIONS

I added mathematical functions into the mix. This was an exercise to see wether my code was open enough to extend upon. Also, another guy in the IRC challenged me to try it, so yeah. They look somewhat like this:

```
sqrt(3 + 3 + sqrt(9))
```

As you can see above, nesting is supported for functions too.

## Check it out for yourself.

You can run the code from the terminal, which gives you an interactive window to send mathematical queries to.

```
$ php calculator_assignment.php
```

… and off you go.

## Conslusion

I'm actually against these coding challenges which are time based. They should be about coding the best thing in a reasonable time. Of course you could do something easier (I took it a bit too far) but if you want to know how somebody codes, look for open-source contributions. Those contributions show you how a developer works, not by him/herself but within a group. That shows way more skill than a random brainfart like this.

# [DISCLAIMER]

I did not add docblocks, I normally do.