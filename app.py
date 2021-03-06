from flask import Flask, request,render_template, redirect
from flask_sqlalchemy import SQLAlchemy
import os
from werkzeug.utils import secure_filename

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///test.db'

db = SQLAlchemy(app)

class Students(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(100))
    phone = db.Column(db.Integer)
    pic = db.Column(db.String)

#----------------------------- Home Starts Here -----------------------------------
@app.route('/', methods=["GET","POST"])
def index():
    if request.method=="POST":
        name = request.form["name"]
        phone = request.form["phone"]
        file = request.files['pic']
        fname= 'static/images/photos/'+secure_filename(file.filename)
        file.save(fname)
        info=Students(name=name, phone=phone, pic=fname)
        db.session.add(info)
        db.session.commit()
    fetch=Students.query.all()

    return render_template("index.html", getinfo=fetch)
#----------------------------- Home Ends Here -----------------------------------

#----------------------------- Update Starts Here -----------------------------------
@app.route('/updater', methods=["GET","POST"])
def updater():
    if request.method=="POST":
        pid = request.form['pid']
        name = request.form["name"]
        phone = request.form["phone"]
        fetch=Students.query.filter_by(id=pid).first()
        fetch.name=name
        fetch.phone=phone
        file = request.files['pic']
        fname= 'static/images/photos/'+secure_filename(file.filename)
        file.save(fname)
        fetch.pic=fname
        db.session.commit()
        return redirect("/")

@app.route('/update', methods=["GET","POST"])
def update():
    id = request.args['id']
    fetch=Students.query.filter_by(id=id).all()
    return render_template("update.html",getinfo=fetch)

#----------------------------- Update Ends Here -----------------------------------

#----------------------------- Delete Starts Here -----------------------------------
@app.route('/delete/<int:id>', methods=["GET","POST"])
def delete(id):
    fetch=Students.query.filter_by(id=id).first()
    db.session.delete(fetch)
    db.session.commit()
    return redirect("/")
#----------------------------- Delete Ends Here -----------------------------------

if __name__ == '__main__':
   app.run(debug=True)