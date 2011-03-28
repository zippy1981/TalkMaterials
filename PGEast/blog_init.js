db.articles.drop();

var blog = {
	title: "Postgres and mongo",
	article: "<p>Postgres is an awesome relational database, and mongo is an awesome nonrelational database.</p>",
	comments: [
		{
			name: 'Staniel T Johnson',
			email: 'staniel@johnson.com',
			comment: 'First!!!'
		},
		{
			name: 'Justin Dearing',
			email: 'zippy1981@gmail.com',
			comment: 'I <b>heartily</b> agree!!!<br/>I use Mongo and postgres all the time',
			comments: [
				{
					name: 'Trolly McTroll',
					email: 'troll@slashdot.org',
					comment: 'Postgres is slow, and mongo is unstable, use MySQL!!!'
				}
			]
		},
		{
			name: 'Spammy McSpan',
			email: 'v1agra@spamb0t.com',
			comment: '<p>Cheap viagra from china without a prescription!!</p>'
		}
	]
};

db.articles.insert(blog);
