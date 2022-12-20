#!/usr/bin/env python3
#import django
#django.setup()

#from djangohotsauce.controllers.wsgi import WSGIController
#wsgi_app = WSGIController()
from django.core.wsgi import get_wsgi_application

def application(environ, start_response):
    app = get_wsgi_application()
    return app(environ, start_response)

