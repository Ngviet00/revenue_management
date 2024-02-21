using AutoMapper;
using Microsoft.EntityFrameworkCore;
using RevenueManagement.Context;
using RevenueManagement.Models.Entities;
using RevenueManagement.Models.Requests.User;

namespace RevenueManagement.Services
{
    public class UserService
    {
        private readonly ApplicationDbContext _context;
        private readonly IMapper _mapper;

        public UserService(ApplicationDbContext _context, IMapper _mapper)
        {
            this._context = _context;
            this._mapper = _mapper;
        }

        public async Task<List<User>> GetAll()
        {
            return await _context.Users.AsNoTracking().ToListAsync();
        }

        public async Task<User>? GetById(long userId)
        {
            return await _context.Users.AsNoTracking().FirstOrDefaultAsync(x => x.Id == userId);
        }

        public async Task<bool> ChangePassword(User user, string newPassword)
        {
            try
            {
                user.Password = Utils.Security.MD5Hash(newPassword);

                _context.Entry(user).State = EntityState.Modified;
                await _context.SaveChangesAsync();

                return true;
            }
            catch (Exception exception)
            {
                Console.WriteLine(exception);
            }

            return false;
        }

        public bool CheckPassword(User user, string currentPassword)
        {
            return user.Password == Utils.Security.MD5Hash(currentPassword);
        }

        public async Task<bool> UpdateInformation(User user)
        {
            try
            {
                _context.Entry(user).State = EntityState.Modified;
                await _context.SaveChangesAsync();
                return true;
            }
            catch (Exception ex)
            {
                Console.WriteLine(ex);
                throw;
            }
        }

        public async Task<bool> Save(StoreUserRequest request)
        {
            try
            {
                var user = new User
                {
                    Name = request.Name,
                    Username = request.Username,
                    Password = Utils.Security.MD5Hash(request.Password),
                    Phone = request.Phone,
                    Email = request.Email,
                    Image = request.Image,
                    Sex = request.Sex,
                    DateOfBirth = request.DateOfBirth,
                    RoleId = request.RoleId,
                };

                await _context.Users.AddAsync(user);
                await _context.SaveChangesAsync();

                return true;
            }
            catch (Exception ex)
            {
                Console.WriteLine(ex);
                throw;
            }
        }

        public async Task<bool> DeleteById(long Id)
        {
            try
            {
                var user = await this.GetById(Id);
                if (user == null)
                {
                    return false;
                }

                this._context.Users.Remove(user);
                await this._context.SaveChangesAsync();

                return true;
            }
            catch (Exception ex)
            {
                Console.WriteLine(ex);
                throw;
            }
        }
    }
}
