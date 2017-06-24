{% extends 'base.html.twig' %}
{% block content %}
	Hallo {{ email|raw }}<br />
	
	{% for array in topicService.getAllTopics() %}
	<li><a href="/topic/{{ array[0] }}">{{ array[0] }}</a></li>
	{% endfor %}
	
{% endblock %}

{% block title %}
	Home - Personal Trainer by {{ parent() }}
{% endblock %}