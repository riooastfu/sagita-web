def findDecision(obj): #obj[0]: Umur, obj[1]: Berat Badan, obj[2]: Jenis Kelamin, obj[3]: Tinggi Badan
	# {"feature": "Berat Badan", "instances": 225, "metric_value": 1.0446, "depth": 1}
	if obj[1] == '5.9-12.2':
		# {"feature": "Umur", "instances": 184, "metric_value": 1.1536, "depth": 2}
		if obj[0] == '25-36':
			# {"feature": "Tinggi Badan", "instances": 64, "metric_value": 1.0137, "depth": 3}
			if obj[3] == '59.6-87.8':
				# {"feature": "Jenis Kelamin", "instances": 57, "metric_value": 1.0518, "depth": 4}
				if obj[2] == 'P':
					return 'Normal'
				elif obj[2] == 'L':
					return 'Normal'
				else: return 'Normal'
			elif obj[3] == '87.9-96.1':
				# {"feature": "Jenis Kelamin", "instances": 6, "metric_value": 0.65, "depth": 4}
				if obj[2] == 'P':
					return 'Normal'
				elif obj[2] == 'L':
					return 'Normal'
				else: return 'Normal'
			elif obj[3] == '96.2-103.3':
				return 'Normal'
			else: return 'Normal'
		elif obj[0] == '37-48':
			# {"feature": "Tinggi Badan", "instances": 54, "metric_value": 0.8686, "depth": 3}
			if obj[3] == '87.9-96.1':
				# {"feature": "Jenis Kelamin", "instances": 28, "metric_value": 0.8059, "depth": 4}
				if obj[2] == 'P':
					return 'Normal'
				elif obj[2] == 'L':
					return 'Normal'
				else: return 'Normal'
			elif obj[3] == '59.6-87.8':
				# {"feature": "Jenis Kelamin", "instances": 24, "metric_value": 0.9738, "depth": 4}
				if obj[2] == 'P':
					return 'Normal'
				elif obj[2] == 'L':
					return 'Normal'
				else: return 'Normal'
			elif obj[3] == '103.4-123.9':
				return 'Normal'
			else: return 'Normal'
		elif obj[0] == '12-24':
			# {"feature": "Jenis Kelamin", "instances": 47, "metric_value": 1.4139, "depth": 3}
			if obj[2] == 'P':
				# {"feature": "Tinggi Badan", "instances": 25, "metric_value": 1.2597, "depth": 4}
				if obj[3] == '59.6-87.8':
					return 'Normal'
				elif obj[3] == '87.9-96.1':
					return 'Normal'
				else: return 'Normal'
			elif obj[2] == 'L':
				# {"feature": "Tinggi Badan", "instances": 21, "metric_value": 1.4937, "depth": 4}
				if obj[3] == '59.6-87.8':
					return 'Gizi Kurang'
				else: return 'Gizi Kurang'
			elif obj[2] == 'K':
				return 'Normal'
			else: return 'Normal'
		elif obj[0] == '49-60':
			# {"feature": "Jenis Kelamin", "instances": 19, "metric_value": 1.2364, "depth": 3}
			if obj[2] == 'L':
				# {"feature": "Tinggi Badan", "instances": 10, "metric_value": 0.9219, "depth": 4}
				if obj[3] == '87.9-96.1':
					return 'Gizi Kurang'
				elif obj[3] == '59.6-87.8':
					return 'Gizi Buruk'
				else: return 'Gizi Buruk'
			elif obj[2] == 'P':
				return 'Normal'
			else: return 'Normal'
		else: return 'Normal'
	elif obj[1] == '12.3-14.3':
		return 'Normal'
	elif obj[1] == '14.4-16.3':
		return 'Normal'
	elif obj[1] == '16.4-27.9':
		return 'Gizi Kurang'
	else: return 'Gizi Kurang'
