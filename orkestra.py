#!/usr/bin/env python
# -*- coding: utf-8 -*-
import web,creds
import smtplib
import email.utils
from email.mime.text import MIMEText

urls = ( '/','Index', '/contact/','Contact' )
index = open('index.html','r')
data = index.read()
index.close()

class Index:
  def GET(self):
    global data
    return data

class Contact:
  def GET(self):
    web.redirect('/')
  def POST(self):
    #Connect to the SMTP server
    sender = smtplib.SMTP()
    sender.connect('smtp.gmail.com',587)
    #gmail auth methods
    sender.ehlo();sender.starttls();sender.ehlo()
    sender.login(creds.email,creds.password)
    try:
      form = web.input()
      #captcha = form['g-recaptcha-response ']
      #if captcha == "": web.redirect('/')
      body = form['message']+"\n\nisim: "+form['name']+"\ne-posta: "+form['email']
      message = MIMEText(body,'plain','utf-8')
      message['To'] = email.utils.formataddr(('Recipient', 'alicanblbl@gmail.com'))
      message['From'] = email.utils.formataddr(('Author', form['email']))
      message['Subject'] = 'ORKESTRA: %s'%form['topic']
      sender.sendmail(form['email'], ['alicanblbl@gmail.com','tanerman@gmail.com','ismailkok@orkestrayazilim.com'], message.as_string())
    finally:
      sender.quit()
      web.redirect('/')

if __name__ == "__main__": 
  web.wsgi.runwsgi = lambda func, addr=None: web.wsgi.runfcgi(func, addr)
  app = web.application(urls, globals())
  app.run()