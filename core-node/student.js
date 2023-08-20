const getStudents = (input, callback) => {
  const students = [
    { name: 'Nithun', email: 'nithun.e@gmail.com' },
    { name: 'Nimisha', email: 'nimisha.e@gmail.com' },
    { name: 'Farsana', email: 'farsana.kallai@gmail.com' },
  ];
  callback(200, { message: '', data: students });
};

// 200
// 300
// 400
// 500
module.exports = getStudents;
