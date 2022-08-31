from flask import Flask, render_template, request, redirect, url_for
from chefboost import Chefboost as cb

app = Flask(__name__)

@app.route('/')
def run_script():
    model = cb.load_model("model.pkl")
    prediction = cb.predict(model, ['37-48',"10-14","L",'0-74.5'])

    return prediction

@app.route('/testing',methods=['POST'])
def testing_data():
    umur    = request.form["umur"]
    berat  = request.form["berat"]
    tinggi = request.form["tinggi"]
    jk     = request.form["jk"]

    model = cb.load_model("model.pkl")
    prediction = cb.predict(model, [umur,berat,jk,tinggi])

    return prediction
    

if __name__ == "__main__":
    app.run(debug=True)