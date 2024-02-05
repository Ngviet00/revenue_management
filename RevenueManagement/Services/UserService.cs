using AutoMapper;
using Microsoft.EntityFrameworkCore;
using RevenueManagement.Context;
using RevenueManagement.Models.DTOs.User;
using RevenueManagement.Models.Entities;

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
            } catch (Exception ex)
            {
                Console.WriteLine(ex);
                throw;
            }
        }
    }
}
