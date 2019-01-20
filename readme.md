# Signifanct flying
Is a system to compose and adjust team structures.

# Scope / Assignment

# Development cmds

```bash
php-cs-fixer fix app --rules=@PSR2,blank_line_before_statement,no_unused_imports,ordered_imports
```

```bash
php artisan code:analyse
```

# Design
## E/R diagram

## Code Coverage
![Code Coverage](https://imgur.com/a/7eixyyy)

# Relevant design choices
- Floats are unprecise, but a little bit easier to work with, rounding instead.

# Uncertainties
- How to evaluate peoples skill level, especially experience

# Taking the project further
- Making the user choose between a set amount of the best team combinations
- Greedy version of suggestion algorithm can be made, to avoid calculating fit for x team suggestions (can not avoid by skill combinations thou)