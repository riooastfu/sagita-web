from chefboost import Chefboost as cb

model = cb.load_model("model.pkl")
prediction = cb.predict(model, ['37-48',"10-14","L",'0-74.5'])
print(prediction)



