# Signifanct flying
Is a system to compose and adjust team structures.

url: http://37.139.8.134
horizon: http://37.139.8.134/horizon

# Scope / Assignment
In regards to what Tore said, rough paraphrasing "we are not trying to be a traditional agency, we are trying to get people to do it our way". I felt this task led down one road, making a CRUD API for a team like structure.

I felt if i should present this to a customer and sell this idea, it should be something special. Everyone can make a CRUD API, i wanted the team formation to be automatic, so the system calculates which team can handle the assignments.

I chose to not include any front end, this is a backend assignment and Tore did agree with this. I thou prioritised the server setup a little more instead. Which is way more relevant for what i should do. There is a JSON API which should be more than enough fun to explore.
# Adding data - Using the api
Tweak the seeders if data needs to be added, run it usual Laravel style. There is sample data i would suggest calling the api with the following call.

There is two get routes, http://37.139.8.134/api/teams/$id and http://37.139.8.134/api/people mostly for data exploration.

Example input

```bash
curl -X POST \
  http://37.139.8.134/api/teams \
  -H 'Accept: application/json' \
  -H 'Content-Type: application/json' \
  -H 'Postman-Token: a46fab9d-b8e3-4e6d-a889-290f1308cffc' \
  -H 'cache-control: no-cache' \
  -d '{
	"name": "martins team",
	"priority": "medium",
	"team": [
		{
			"skill": "Backender",
			"amount": 2
		},
		{
			"skill": "Manager",
			"amount": 2
		},
				{
			"skill": "Frontender",
			"amount": 2
		}
		]
}'
```

Example response (People will be added later on a job in production)
```
{
    "data": {
        "id": 46,
        "name": "martins team",
        "priority": "medium",
        "fit": 99.6667,
        "people": [
            {
                "id": 5,
                "name": "Backender INTERN",
                "experience": 2,
                "forSkill": "Backender",
                "skillLevels": {
                    "Backender": 0.25
                }
            },
            {
                "id": 2,
                "name": "Backender Senior",
                "experience": 1,
                "forSkill": "Backender",
                "skillLevels": {
                    "Backender": 0.72
                }
            },
            {
                "id": 8,
                "name": "Manager 3",
                "experience": 1,
                "forSkill": "Manager",
                "skillLevels": {
                    "Manager": 0.34
                }
            },
            {
                "id": 7,
                "name": "Manager 2",
                "experience": 2,
                "forSkill": "Manager",
                "skillLevels": {
                    "Manager": 0.58
                }
            },
            {
                "id": 11,
                "name": "Frontender 3",
                "experience": 0,
                "forSkill": "Frontender",
                "skillLevels": {
                    "Frontender": 0.2
                }
            },
            {
                "id": 9,
                "name": "Frontender 1",
                "experience": 5,
                "forSkill": "Frontender",
                "skillLevels": {
                    "Frontender": 0.9
                }
            }
        ]
    }
}
```

# Development cmds

```bash
php-cs-fixer fix app --rules=@PSR2,blank_line_before_statement,no_unused_imports,ordered_imports
```

```bash
php artisan code:analyse
```

# Design
### E/R diagram
Note: i draw a weird mix or an ER diagram combined with a class diagram, but 3 years of experience and no one has complained :)

[2. version of ER](https://imgur.com/a/OV0SZdU)

Slept on the team to people relation i found out when making the code.

[1. version](https://imgur.com/a/7Izp2cz)

## Calculating peoples skill
I needed to translate a persons abilities into a  number to priorities the teams. The following equation was used.

```bash
SkillCoeficient * EducationCoeficient * ExperienceCoeficient = A percentage
```

I tryed to create a formula that took into consideration people don't need to have a PHD background to be an expert.
All Coeficients are thought of as percentages, and the general consensus in the values are that 100% is extremely high, 75% is senior level, 50% is the middle of the pack and 25% is low skill levels.

This is roughly done and considering the time frame, i am quite happy with the result. The education and skill coefficients are set manually and experience is calculated out from the idea that after 3  years of work experience in Signifly you should be up and running. Each year less then that decucts 10% from your skill level.

Then i create all combinations of the given persons with the skills and calculated how well the team combinations fit the team. The team has to provide how many of each skill they need, like 1 manager, 2 backenders and 2 frontenders. While also providing a priority, which basicly translate to the values described above.

After the job has ranned, a team is set and how close to the priority it hits is calculated again out from the deviation in percentage. For future proofing this, adding suggestions and tweaking of the teams would be a great feature. 

### Code Coverage
[Code Coverage](https://imgur.com/a/7eixyyy)

### Choices
- Floats are unprecise, but a little bit easier to work with, rounding instead.
- The combination of team suggestions can be quite rough, thats why it is a job (not super scaleable atm).
- Did not optimise queries using the with statement, which i should haved but ran out of time.

### Uncertainties
- How to evaluate peoples skill level, especially experience

### Taking the project further
- Making the user choose between a set amount of the best team combinations
- CRUD routes for manual adjusting the teams
- Greedy version of suggestion algorithm can be made, to avoid calculating fit for x team suggestions (can not avoid by skill combinations thou)
- There is a dynamic programming solution to this problem, if we play with the thought that skill calculation is quite a though operation.

# Time used
[toggl](https://imgur.com/a/4qbl3h0)