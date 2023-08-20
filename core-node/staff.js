const getStaffs = (input, callback) => {
  const staff = [
    { name: 'Alan', email: 'alan.a@gmail.com' },
    { name: 'Shakkeer', email: 'shakkeer.ali@gmail.com' },
    { name: 'Aslam', email: 'aslam.m@gmail.com' },
  ];
  callback(200, { message: '', data: staff });
};

module.exports = getStaffs;
