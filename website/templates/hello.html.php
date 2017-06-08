{% extends 'base.html.twig' %}
{% block content %}
	Das kommt aus meinem ersten Template<br />
	Hallo {{ name|raw }}
{% endblock %}

{% block title %}
	{{ parent() }} - Meine tolle Seite
{% endblock %}